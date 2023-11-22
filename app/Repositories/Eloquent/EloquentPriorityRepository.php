<?php

namespace App\Repositories\Eloquent;

use App\Repositories\PriorityRepository;

class EloquentPriorityRepository extends EloquentBaseRepository implements PriorityRepository
{
    public function list(array $params)
    {
        $datas = $this->model
        
        ->when(isset($params['search']), function($q) use ($params) {
            return $q->where('name' ,'like', '%'.$params['search'].'%');
        });

        if(!isset($params['per_page'])) {
            return $datas->get();
        }

        return $datas->paginate($params['per_page']);
    }   
}
