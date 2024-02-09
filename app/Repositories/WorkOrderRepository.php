<?php 

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Models\WorkOrder;

interface WorkOrderRepository {
    
    public function createWorkOrder(array $data, array $items);

    public function updateWorkOrder( WorkOrder $work_order ,array $data, array $items);

    public function list(array $params);

    public function statusChanged(WorkOrder $work_order, $status);
    
    public function overview(array $params);

    public function reportWorkOrderDaily($params);

}