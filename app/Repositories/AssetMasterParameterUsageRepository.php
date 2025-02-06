<?php 

namespace App\Repositories;

use App\Models\AssetMaster;
use App\Models\AssetMasterParameterUsage;

interface AssetMasterParameterUsageRepository {
    public function updateUsage(AssetMasterParameterUsage $assetMasterParameterUsage , $usage);
    public function historyAsset(array $params);
}