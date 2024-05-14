<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use App\Repositories\TenantRepository;
use Illuminate\Http\Request;

class TenantController extends Controller
{

    protected $tenant_repo;

    public function __construct()
    {
        $this->tenant_repo = app(TenantRepository::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $tenants = $this->tenant_repo->list($request->all());

        return TenantResource::collection($tenants);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'virtual_account' => 'required|string',
            'bank' => 'required|string',
            'npwp' => 'required|string'
        ]);

        $tenant = $this->tenant_repo->createTenant($request->all() , $request->file('file_logo', null));

        return response()->json([
            'message' => 'Success add tenant',
            'data' => new TenantResource($tenant)
        ]);
    }

    public function update(Tenant $tenant, Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'virtual_account' => 'required|string',
            'bank' => 'required|string',
            'npwp' => 'required|string'
        ]);

        $tenant = $this->tenant_repo->updateTenant($tenant, $request->all() , $request->file('file_logo', null));

        return response()->json([
            'message' => 'Tenant update successfuly',
            'data' => new TenantResource($tenant)
        ]);
    }

    public function show(Tenant $tenant)
    {
        return new TenantResource($tenant);
    }

    public function destroy(Tenant $tenant)
    {

        $this->tenant_repo->destroy($tenant);

        return response()->json([
            'message' => 'Tenant delete successfuly'
        ]);
    }
}
