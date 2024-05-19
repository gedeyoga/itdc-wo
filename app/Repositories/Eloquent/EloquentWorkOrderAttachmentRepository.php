<?php

namespace App\Repositories\Eloquent;

use App\Events\WorkOrderAttachmentCreated;
use App\Events\WorkOrderAttachmentUpdated;
use App\Events\WorkOrderFinished;
use App\Events\WorkOrderPending;
use App\Events\WorkOrderProgress;
use App\Models\Task;
use App\Models\WorkOrder;
use App\Models\WorkOrderAttachment;
use App\Repositories\HistoryPompaRepository;
use App\Repositories\WorkOrderAssigneeRepository;
use App\Repositories\WorkOrderAttachmentRepository;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderRepository;

class EloquentWorkOrderAttachmentRepository extends EloquentBaseRepository implements WorkOrderAttachmentRepository
{
    public function createAttachment(array $data)
    {

        $model = $this->create($data);

        event(new WorkOrderAttachmentCreated($model));

        return $model;

    }

    public function updateAttachment(WorkOrderAttachment $workOrderAttachment, array $data)
    {
        $model = $this->update($workOrderAttachment, $data);

        event(new WorkOrderAttachmentUpdated($model));

        return $model;
    }
}
