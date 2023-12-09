<?php

namespace App\Repositories\Eloquent;

use App\Events\WorkOrderCancel;
use App\Events\WorkorderCreated;
use App\Events\WorkOrderFinished;
use App\Events\WorkOrderPending;
use App\Events\WorkOrderProgress;
use App\Events\WorkorderUpdated;
use App\Models\Task;
use App\Models\WorkOrder;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderRepository;

class EloquentWorkOrderRepository extends EloquentBaseRepository implements WorkOrderRepository
{

    public function createWorkOrder(array $data, array $items)
    {
        //status hanya bisa dirubah pada fungsi statusChanged
        $data = $this->removeStatusInArray($data);

        $work_item_repo = app(WorkOrderItemRepository::class);

        $work_order = $this->create($data);

        $this->statusChanged($work_order, 'pending');

        foreach ($items as $item) {
            $item['work_order_id'] = $work_order->id;
            $work_item_repo->createItem($item);   
        }

        event(new WorkorderCreated($work_order));

        return $work_order;
    }

    public function updateWorkOrder(WorkOrder $work_order, array $data, array $items)
    {
        //status hanya bisa dirubah pada fungsi statusChanged
        $data = $this->removeStatusInArray($data);

        $work_item_repo = app(WorkOrderItemRepository::class);
        $model = $this->update($work_order , $data);

        $work_item_repo->removeUnusedItem($model->work_order_items, $items);

        foreach ($items as $item) {

            $media = isset($item['media']) ? $item['media'] : null;

            if(isset($item['id'])) {
                $wo_item = $work_item_repo->find($item['id']);
                $work_item_repo->updateItem($wo_item , $item , $media);

            }else {
                $item['work_order_id'] = $model->id;
                $data = $work_item_repo->createItem($item, $media);
            }
        }

        event(new WorkorderUpdated($model));

        return $model->refresh();
    }

    public function list(array $params)
    {

        $datas = $this->model

        ->when(isset($params['relations']) , function($q) use ($params) {
            $relations = explode(',', $params['relations']);
            return $q->with($relations);
        })
        
        ->when(isset($params['priority_id']) , function($q) use ($params) {
            return $q->where('priority_id' , $params['priority_id']);
        })

        ->when(isset($params['task_category_id']) , function($q) use ($params) {
            return $q->where('task_category_id', $params['task_category_id']);
        })

        ->when(isset($params['date']) , function($q) use ($params) {
            return $q->whereBetween('date', $params['date']);
        })

        ->when(isset($params['status']) , function($q) use ($params) {
            return $q->where('status', $params['status']);
        })

        ->when(isset($params['user_id']) , function($q) use ($params) {
            return $q->whereHas('assignees', fn($q) => $q->where('user_id' , $params['user_id']));
        })

        ->when(isset($params['search']) , function($q) use ($params) {
            return $q->where(function($q) use ($params){
                $q->where('name' , 'like' , '%'.$params['search'].'%')
                    ->orWhere('code' , 'like' , '%'.$params['search'].'%');
            });
        })

        ->orderBy('created_at', 'desc');

        if(!isset($params['per_page'])) {
            return $datas->get();
        }

        return $datas->paginate($params['per_page']);

    }

    public function statusChanged(WorkOrder $work_order, $status)
    {

        $model = $this->update($work_order , ['status' => $status]);

        if($model->status == 'pending') {

            event(new WorkOrderPending($model));

        } else if($model->status == 'progress') {

            event(new WorkOrderProgress($model));

        } else if($model->status == 'finish') {

            event(new WorkOrderFinished($model));

        } else if($model->status == 'cancel') {
            event(new WorkOrderCancel($model));
        };

        return $model;

    }

    protected function removeStatusInArray(array $data)
    {
        if (isset($data['status'])) {
            unset($data['status']);
        }

        return $data;
    }
    
}
