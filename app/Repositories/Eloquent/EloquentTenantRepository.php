<?php

namespace App\Repositories\Eloquent;

use App\Events\UserWasCreated;
use App\Models\Tenant;
use App\Models\User;
use App\Repositories\LocationRepository;
use App\Repositories\TenantRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class EloquentTenantRepository extends EloquentBaseRepository implements TenantRepository
{

    public function list(array $params)
    {
        $datas = $this->model;

        if(isset($params['search'])) {
            $datas = $datas->where(function($query) use ($params) {
                $query->where('name' , 'like' , '%'.$params['search'].'%');
            });
        }

        if (isset($params['order_by']) && isset($params['order'])) {
            $order = $params['order'] == 'ascending' ? 'asc' : 'desc';
            $datas = $datas->orderBy($params['order_by'], $order);
        } else {
            $datas = $datas->orderBy('id', 'desc');
        }


        if(isset($params['per_page'])){
            return $datas->paginate($params['per_page']);
        }

        return $datas->get();
    }

    public function createTenant(array $data , $media = null) 
    {
        $tenant = $this->create($data);

        if ($media instanceof UploadedFile) {
            $name = Str::uuid() . '.' . $media->extension();
            $tenant->addMedia($media)->usingFileName($name)->toMediaCollection('logo');
        }

        return $tenant;
    }

    public function updateTenant( Tenant $tenant , array $data , $media = null) 
    {
        $data = $this->update( $tenant, $data);

        if ($media instanceof UploadedFile) {
            $name = Str::uuid() . '.' . $media->extension();
            $data->addMedia($media)->usingFileName($name)->toMediaCollection('logo');
        }

        return $tenant;
    }
    
}
