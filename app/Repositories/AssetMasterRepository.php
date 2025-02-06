<?php 

namespace App\Repositories;

use App\Models\AssetMaster;

interface AssetMasterRepository {
    
    public function createAssetMaster(array $data, $items = null);

    public function updateAssetMaster( AssetMaster $model, array $data, $items = null);

    public function list(array $params);

}