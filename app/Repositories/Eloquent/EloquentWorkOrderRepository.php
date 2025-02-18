<?php

namespace App\Repositories\Eloquent;

use App\Events\WorkOrderCancel;
use App\Events\WorkorderCreated;
use App\Events\WorkOrderFinished;
use App\Events\WorkOrderPending;
use App\Events\WorkOrderProgress;
use App\Events\WorkorderUpdated;
use App\Models\Task;
use App\Models\User;
use App\Models\WorkOrder;
use App\Repositories\WorkOrderAttachmentRepository;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderRepository;
use Illuminate\Support\Facades\DB;

class EloquentWorkOrderRepository extends EloquentBaseRepository implements WorkOrderRepository
{

    public function createWorkOrder(array $data, array $items)
    {
        //status hanya bisa dirubah pada fungsi statusChanged
        $data = $this->removeStatusInArray($data);

        $work_item_repo = app(WorkOrderItemRepository::class);
        $work_order_attachment_repo = app(WorkOrderAttachmentRepository::class);

        $work_order = $this->create($data);

        $this->statusChanged($work_order, 'pending');

        foreach ($items as $item) {
            $item['work_order_id'] = $work_order->id;
            $work_item_repo->createItem($item);   
        }

        if (isset($data['work_order_attachments']) && is_array($data['work_order_attachments'])) {
            foreach ($data['work_order_attachments'] as $value) {
                $explode = explode(':', $value);
                if (count($explode) == 2) {
                    // $work_order->work_order_attachments()->create([
                    //     'work_order_id' => $work_order->id,
                    //     'attach_id' => $explode[0],
                    //     'attach_type' => $explode[1],
                    // ]);

                    $work_order_attachment_repo->createAttachment([
                        'work_order_id' => $work_order->id,
                        'attach_id' => $explode[0],
                        'attach_type' => $explode[1],
                    ]);
                }
            }
        }

        event(new WorkorderCreated($work_order));

        return $work_order;
    }

    public function updateWorkOrder(WorkOrder $work_order, array $data, array $items)
    {
        //status hanya bisa dirubah pada fungsi statusChanged
        $data = $this->removeStatusInArray($data);

        $work_item_repo = app(WorkOrderItemRepository::class);
        $work_order_attachment_repo = app(WorkOrderAttachmentRepository::class);

        
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

        if (isset($data['fill_history_pompa']) && $data['fill_history_pompa'] == 1) {
            if (isset($data['work_order_attachments']) && is_array($data['work_order_attachments'])) {

                $work_order->work_order_attachments()->delete();

                foreach ($data['work_order_attachments'] as $value) {
                    $explode = explode(':', $value);
                    if (count($explode) == 2) {
                        $work_order_attachment_repo->createAttachment([
                            'work_order_id' => $work_order->id,
                            'attach_id' => $explode[0],
                            'attach_type' => $explode[1],
                        ]);
                    }
                }
            }
        } else if (isset($data['fill_history_pompa']) && $data['fill_history_pompa'] == 0) {
            $work_order->work_order_attachments()->delete();

            $work_order->update([
                'fill_history_pompa' => 0
            ]);
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
            return $q->whereBetween('date', [
                date('Y-m-d 00:00:00' , strtotime($params['date'][0])),
                date('Y-m-d 23:59:59' , strtotime($params['date'][1])),
            ]);
        })

        ->when(isset($params['status']) , function($q) use ($params) {
           if(!is_array($params['status'])) {
                return $q->where('status', $params['status']);
           }else{
                return $q->whereIn('status', $params['status']);
           }
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

    public function overview(array $params)
    {
        $datas = $this->model
            ->select([
                DB::raw("status"),
                DB::raw("count(status) as amount"),
            ])

            ->when(isset($params['date']) && is_array($params['date'] && count($params['date']) == 2), function ($q) use ($params) {
                return $q->whereBetween('date', [
                    date('Y-m-d 00:00:00' , strtotime($params['date'][0])),
                    date('Y-m-d 23:59:59' , strtotime($params['date'][1]))
                ]);
            })

            ->when(isset($params['user_id']), function ($q) use ($params) {
                return $q->whereHas('assignees', fn ($q) => $q->where('user_id', $params['user_id']));
            })

            ->groupBy('status');

        return $datas->get();
    }

    public function reportWorkOrderDaily($params)
    {
        $group_status = $this->model->select([
            'work_orders.status',
            DB::raw('count(id) as jumlah_status'),
        ])->whereBetween('date' ,  $params['dates'])
        ->groupBy('status')
        ->get();

        $group_assignees = $this->model->select([
            'users.*',
        ])
        ->join('work_order_assignees', 'work_order_assignees.work_order_id' , 'work_orders.id')
        ->join('users' , 'users.id' , 'work_order_assignees.user_id')
        ->whereBetween('date',  $params['dates'])
        ->groupBy('work_order_assignees.user_id')
        ->get();

        $group_locations = $this->model->select([
            'locations.*',
        ])
        ->join('locations', 'locations.id', 'work_orders.location_id')
        ->groupBy('work_orders.location_id')
        ->whereBetween('date',  $params['dates'])
        ->get();


        return [
            'group_status' => $group_status,
            'group_assignees' => $group_assignees,
            'group_locations' => $group_locations
        ];
    
    }

    public function reportWorkOrderMonthly($params)
    {
        $user = new User();
        $columns = ['users.*'];

        $daysOfMonth = isset($params['date']) ? date('t' , strtotime($params['date'])) : date('t');
        $month = isset($params['date']) ? date('Y-m' , strtotime($params['date'])) : date('Y-m');

        for ($day=1; $day <= $daysOfMonth; $day++) { 
            $date = date('Y-m-d' , strtotime($month . '-' . $day));

            array_push(
                $columns, 
                DB::raw("
                    (
                        round(((
                            SELECT 
                                count(work_orders.id) as jumlah
                            FROM `work_order_assignees`
                                JOIN work_orders ON work_orders.id = work_order_assignees.work_order_id
                            where 
                                work_orders.date like '" . $date . "%' and 
                                work_order_assignees.user_id = users.id and
                                work_orders.status = 'finish'
                            group by work_order_assignees.user_id	
                        ) 
                        /
                        (
                            SELECT 
                                count(work_orders.id) as jumlah
                            FROM `work_order_assignees`
                                JOIN work_orders ON work_orders.id = work_order_assignees.work_order_id
                            where 
                                work_orders.date like '" . $date ."%' and 
                                work_order_assignees.user_id = users.id
                            group by work_order_assignees.user_id
                        )) * 100)
                    ) AS '" . $date . "'
                ")
            );
        }

        $user = $user->select($columns);

        if(isset($params['per_page'])) {
            return $user->paginate($params['per_page']);
        }

        return $user->get();
    }
    
}
