<?php

namespace App\Repositories\Eloquent;

use App\Events\WorkorderCreated;
use App\Events\WorkOrderFinished;
use App\Events\WorkOrderPending;
use App\Events\WorkOrderProgress;
use App\Events\WorkorderUpdated;
use App\Models\WorkOrder;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderLogRepository;

class EloquentWorkOrderLogRepository extends EloquentBaseRepository implements WorkOrderLogRepository
{
    
}
