<?php 

namespace App\Repositories;

use App\Models\Tenant;

interface TenantRepository {

    public function list(array $params);
    public function createTenant(array $data, $media = null);
    public function updateTenant( Tenant $tenant , array $data, $media = null);

}