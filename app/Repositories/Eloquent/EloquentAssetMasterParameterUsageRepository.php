<?php

namespace App\Repositories\Eloquent;

use App\Models\AssetMaster;
use App\Models\AssetMasterParameterUsage;
use App\Repositories\AssetMasterParameterUsageRepository;
use App\Repositories\AssetMasterRepository;
use Illuminate\Support\Facades\DB;

class EloquentAssetMasterParameterUsageRepository extends EloquentBaseRepository implements AssetMasterParameterUsageRepository
{
    public function updateUsage(AssetMasterParameterUsage $assetMasterParameterUsage , $usage)
    {
        $latest_data = $this->model
            ->where('asset_id' , $assetMasterParameterUsage->asset_id)
            ->where('asset_parameter_id' , $assetMasterParameterUsage->asset_parameter_id)
            ->where('id' , '<>', $assetMasterParameterUsage->id)
            ->orderBy('id' , 'desc')
            ->first();
        
        $before = !is_null($latest_data) ? $latest_data->after : 0;
        $after = $usage;

        return $this->update($assetMasterParameterUsage, [
            'after' => $after,
            'before' => $before,
            'selisih' => $after - $before
        ]);
    }

    public function historyAsset(array $params)
    {
        $asset_master_repo = app(AssetMasterRepository::class);

        $params['relations'] = 'asset_parameters.latest_usage';
        $datas = $asset_master_repo->list($params);

        return $datas;
    }

    public function historyAssetDetail($asset_id , array $params)
    {
        $asset_master_repo = app(AssetMasterRepository::class);

        $asset_master = $asset_master_repo->find($asset_id);

        if(is_null($asset_master)) {
            return collect();
        }
        
        $asset_master->load([
            'asset_parameters.asset_usages' => function($q) use ($params) {
                $q->when(isset($params['relations']) , function($q) use($params) {
                    $relations = explode(',', $params['relations']);
                    return $q->with($relations);
                })
                ->when(isset($params['periode']) , function($q) use($params) {
                    return $q->whereBetween('created_at' , [
                        date('Y-m-01 00:00:00' , strtotime($params['periode'])),
                        date('Y-m-t 23:59:59' , strtotime($params['periode'])),
                    ]);
                })
                ->whereRaw("
                    asset_master_parameter_usages.id in (
                        SELECT max(id) FROM asset_master_parameter_usages GROUP BY asset_id, asset_parameter_id, DATE_FORMAT(created_at, '%Y-%m-%d')
                    )
                ");
            }
        ]);

        return $asset_master->asset_parameters;
    }
}
