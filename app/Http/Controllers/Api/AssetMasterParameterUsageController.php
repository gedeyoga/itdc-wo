<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssetMasterParameterResource;
use App\Http\Resources\AssetMasterParameterUsageResource;
use App\Models\AssetMasterParameter;
use App\Repositories\AssetMasterParameterUsageRepository;
use Illuminate\Http\Request;

class AssetMasterParameterUsageController extends Controller
{
    protected $asset_parameter_usage_repo;

    public function __construct()
    {
        $this->asset_parameter_usage_repo = app(AssetMasterParameterUsageRepository::class);
    }

    public function updateUsageData(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'usage' => 'required'
        ]);

        $asset_usage = $this->asset_parameter_usage_repo->find($request->get('id'));

        $new_asset_usage = $this->asset_parameter_usage_repo->updateUsage($asset_usage, $request->get('usage'));

        return response()->json([
            'message' => 'Update usage asset successfuly',
            'data' => new AssetMasterParameterUsageResource($new_asset_usage)
        ]);
    }

    public function historyAsset(Request $request)
    {
        $datas = $this->asset_parameter_usage_repo->historyAsset($request->all());

        return AssetMasterParameterUsageResource::collection($datas);
    }

    public function detail(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'periode' => 'required'
        ]);

        $datas = $this->asset_parameter_usage_repo->historyAssetDetail($request->get('asset_id') , $request->except(['asset_id']));

        return AssetMasterParameterResource::collection($datas);

    }
}
