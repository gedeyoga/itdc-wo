<?php

namespace App\Repositories\Eloquent;

use App\Events\UserWasCreated;
use App\Models\User;
use App\Repositories\LocationInstallationRepository;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class EloquentLocationInstallationRepository extends EloquentBaseRepository implements LocationInstallationRepository
{

    public function list(array $params)
    {
        $location_installations = $this->model;

        if(isset($params['search'])) {
            $location_installations = $location_installations->where(function($query) use ($params) {
                $query->where('name' , 'like' , '%'.$params['search'].'%');
            });
        }

        if(isset($params['relations'])) {
            $relations = explode(',', $params['relations']);
            $location_installations = $location_installations->with($relations);
        }

        if(isset($params['location_id'])) {
            $location_installations = $location_installations->where('location_id', $params['location_id']);;
        }

        if (isset($params['pompa_id'])) {
            $location_installations = $location_installations->where('pompa_id', $params['pompa_id']);
        }

        if (isset($params['status'])) {
            $location_installations = $location_installations->where('status' , $params['status']);
        }

        if (isset($params['order_by']) && isset($params['order'])) {
            $order = $params['order'] == 'ascending' ? 'asc' : 'desc';
            $location_installations = $location_installations->orderBy($params['order_by'], $order);
        } else {
            $location_installations = $location_installations->orderBy('id', 'desc');
        }

        if(isset($params['per_page'])){
            return $location_installations->paginate($params['per_page']);
        }

        return $location_installations->get();
    }
    
}
