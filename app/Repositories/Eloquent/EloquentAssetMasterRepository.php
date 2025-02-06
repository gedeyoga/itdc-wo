<?php

namespace App\Repositories\Eloquent;

use App\Events\WorkOrderCancel;
use App\Events\WorkorderCreated;
use App\Events\WorkOrderFinished;
use App\Events\WorkOrderPending;
use App\Events\WorkOrderProgress;
use App\Events\WorkorderUpdated;
use App\Models\AssetMaster;
use App\Models\AssetMasterParameter;
use App\Models\Task;
use App\Models\User;
use App\Models\WorkOrder;
use App\Repositories\AssetMasterParameterRepository;
use App\Repositories\AssetMasterRepository;
use App\Repositories\WorkOrderAttachmentRepository;
use App\Repositories\WorkOrderItemRepository;
use App\Repositories\WorkOrderRepository;
use Illuminate\Support\Facades\DB;

class EloquentAssetMasterRepository extends EloquentBaseRepository implements AssetMasterRepository
{

    public function createAssetMaster(array $data, $items = null)
    {
        $asset_master = $this->create($data);

        if(is_array($items)) {
            foreach($items as $item) {
                $asset_master->asset_parameters()->create($item);
            }
        }

        return $asset_master;
    }

    public function updateAssetMaster( AssetMaster $model, array $data, $items = null)
    {
        $asset_parameter_repo = app(AssetMasterParameterRepository::class);
        $asset_master = $this->update($model, $data);

        if(is_array($items)) {
            // Sync parameters
            $existingParameterIds = $asset_master->asset_parameters->pluck('id')->toArray();
            $newParameters = [];

            foreach ($items as $item) {
                if (isset($item['id']) && in_array($item['id'], $existingParameterIds)) {
                    // Update existing item
                    $asset_parameter_repo->find($item['id'])->update($item);
                } else {
                    // Add new parameters
                    $newParameters[] = $item;
                }
            }

            // Delete parameters not present in the request
            $idsToDelete = array_diff($existingParameterIds, collect($items)->pluck('id')->toArray());
            AssetMasterParameter::destroy($idsToDelete);

            $asset_master->asset_parameters()->createMany($newParameters);
        }

        return $asset_master;
    }

    public function list(array $params)
    {
        $datas = $this->model

        ->when(isset($params['relations']) , function($q) use ($params) {
            $relations = explode(',', $params['relations']);
            return $q->with($relations);
        })

        ->when(isset($params['status']) , function($q) use ($params) {
           if(!is_array($params['status'])) {
                return $q->where('status', $params['status']);
           }else{
                return $q->whereIn('status', $params['status']);
           }
        })

        ->when(isset($params['search']) , function($q) use ($params) {
            return $q->where(function($q) use ($params){
                $q->where('name' , 'like' , '%'.$params['search'].'%');
            });
        })

        ->orderBy('created_at', 'desc');

        if(!isset($params['per_page'])) {
            return $datas->get();
        }

        return $datas->paginate($params['per_page']);
    }
    
}
