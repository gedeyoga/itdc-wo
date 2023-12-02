<?php

namespace App\Repositories\Eloquent;

use App\Events\WorkOrderFinished;
use App\Events\WorkOrderPending;
use App\Events\WorkOrderProgress;
use App\Models\Task;
use App\Models\WorkOrder;
use App\Repositories\WorkOrderAssigneeRepository;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderRepository;

class EloquentWorkOrderAssigneeRepository extends EloquentBaseRepository implements WorkOrderAssigneeRepository
{

    public function assgineeWorkOrder(WorkOrder $work_order, array $assignees)
    {
        $work_order->assignees()->delete();
        $work_order->assignees()->createMany($assignees);

        return $work_order->assignees;
    }
    
}
