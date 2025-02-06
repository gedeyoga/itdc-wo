<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssetMasterResource;
use App\Models\AssetMaster;
use App\Repositories\AssetMasterRepository;
use Illuminate\Http\Request;

class AssetMasterController extends Controller
{
    protected $asset_master_repo;

    public function __construct()
    {
        $this->asset_master_repo = app(AssetMasterRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $params = $request->all();

        $asset_masters = $this->asset_master_repo->list($params);

        return AssetMasterResource::collection($asset_masters);
    }

    public function store(Request $request)
    {
        $data = $request->except(['asset_parameters']);
        $asset_parameters = $request->get('asset_parameters' , null);

        $asset_master = $this->asset_master_repo->createAssetMaster($data, $asset_parameters);

        return response()->json([
            'message' => 'Create asset successfuly',
            'data' => new AssetMasterResource($asset_master),
            
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetMaster  $assetMaster
     * @return \Illuminate\Http\Response
     */
    public function show(AssetMaster $assetMaster)
    {
        return new AssetMasterResource($assetMaster);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssetMaster  $assetMaster
     * @return \Illuminate\Http\Response
     */
    public function update(AssetMaster $assetMaster, Request $request)
    {
        $data = $request->except(['asset_parameters']);
        $asset_parameters = $request->get('asset_parameters' , null);

        $asset_master = $this->asset_master_repo->updateAssetMaster($assetMaster, $data, $asset_parameters);

        return response()->json([
            'message' => 'Update asset successfuly',
            'data' => new AssetMasterResource($asset_master),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssetMaster  $assetMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssetMaster $assetMaster)
    {
        $this->asset_master_repo->destroy($assetMaster);

        return response()->json([
            'message' => 'Asset delete successfuly'
        ]);
    }
}
