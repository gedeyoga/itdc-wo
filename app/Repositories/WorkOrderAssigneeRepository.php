<?php 

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Models\WorkOrder;

interface WorkOrderAssigneeRepository {

    public function assgineeWorkOrder(WorkOrder $work_order, array $user_ids);

}