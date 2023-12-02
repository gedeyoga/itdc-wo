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
        $users = $this->model;

        if(isset($params['search'])) {
            $users = $users->where(function($query) use ($params) {
                $query->where('name' , 'like' , '%'.$params['search'].'%');
            });
        }

        if(isset($params['per_page'])){
            return $users->paginate($params['per_page']);
        }

        return $users->get();
    }
    
}
