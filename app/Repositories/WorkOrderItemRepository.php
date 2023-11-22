<?php 

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use Illuminate\Database\Eloquent\Collection;

interface WorkOrderItemRepository {
    
    public function createItem(array $data , $media = null);

    public function updateItem(WorkOrderItem $work_order_item , array $data , $media = null);

    public function removeUnusedItem(Collection $item_old, array $data_new);

}