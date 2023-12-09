<?php

namespace App\Repositories\Eloquent;

use App\Models\WorkOrder;
use App\Models\WorkOrderItem;
use App\Repositories\WorkOrderItemRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EloquentWorkOrderItemRepository extends EloquentBaseRepository implements WorkOrderItemRepository
{

    public function createItem(array $data, $media = null)
    {
        $work_order_item = $this->create($data);

        if($media instanceof UploadedFile) {
            $name = Str::uuid() . '.' . $media->extension();
            $work_order_item->addMedia($media)->usingFileName($name)->toMediaCollection('media');
        }

        return $work_order_item;
    }

    public function updateItem(WorkOrderItem $work_order_item, array $data, $media = null)
    {
        $work_order_item = $this->update($work_order_item, $data);

        if ($media instanceof UploadedFile) {
            $name = Str::uuid() . '.' . $media->extension();
            $work_order_item->addMedia($media)->usingFileName($name)->toMediaCollection('media');
        }

        return $work_order_item;
    }
    
    public function removeUnusedItem(Collection $item_old, array $data_new)
    {
        $new_ids = [];

        foreach ($data_new as $item) {
            if(isset($item['id'])) {
                array_push($new_ids, $item['id']);
            }
        }

        $id_not_deletes = collect();

        $item_old->each(function($item) use ($new_ids, $id_not_deletes) {
            if(!in_array($item->id, $new_ids)) {
                $this->destroy($item, $item->id);
            }else {
                $id_not_deletes->push($item);
            }
        });

        return $id_not_deletes;
    }

}
