<?php

namespace App\Repositories\Eloquent;

use App\Events\WorkOrderFinished;
use App\Events\WorkOrderPending;
use App\Events\WorkOrderProgress;
use App\Models\Task;
use App\Models\WorkOrder;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderRepository;

class EloquentWorkOrderRepository extends EloquentBaseRepository implements WorkOrderRepository
{

    public function createWorkOrder(array $data, array $items)
    {
        //status hanya bisa dirubah pada fungsi statusChanged
        $this->removeStatusInArray($data);

        $work_item_repo = app(WorkOrderItemRepository::class);

        $work_order = $this->create($data);

        foreach ($items as $item) {
            $item['work_order_id'] = $work_order->id;
            $work_item_repo->createItem($item);   
        }

        return $work_order;
    }

    public function updateWorkOrder(WorkOrder $work_order, array $data, array $items)
    {
        //status hanya bisa dirubah pada fungsi statusChanged
        $this->removeStatusInArray($data);

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

        };

        return $model;

    }

    protected function removeStatusInArray(array $data)
    {
        if (isset($data['status'])) {
            unset($data['status']);
        }
    }
    
}
