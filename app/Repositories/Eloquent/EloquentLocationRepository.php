<?php

namespace App\Repositories\Eloquent;

use App\Events\UserWasCreated;
use App\Models\User;
use App\Repositories\LocationRepository;
use Illuminate\Http\Request;

class EloquentLocationRepository extends EloquentBaseRepository implements LocationRepository
{

    public function list(array $params)
    {
        $locations = $this->model;

        if(isset($params['search'])) {
            $locations = $locations->where(function($query) use ($params) {
                $query->where('name' , 'like' , '%'.$params['search'].'%');
            });
        }

        $locations = $locations->orderByDesc('created_at');

        if(isset($params['per_page'])){
            return $locations->paginate($params['per_page']);
        }

        return $locations->get();
    }
    
}
