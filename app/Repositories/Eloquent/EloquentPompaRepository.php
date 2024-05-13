<?php

namespace App\Repositories\Eloquent;

use App\Repositories\PompaRepository;

class EloquentPompaRepository extends EloquentBaseRepository implements PompaRepository
{
    public function list(array $params)
    {
        $datas = $this->model
        
        ->when(isset($params['search']), function($q) use ($params) {
            return $q->where('name' ,'like', '%'.$params['search'].'%')
                    ->orWhere('merk' , 'like' , '%' . $params['search'] . '%')
                    ->orWhere('type', 'like', '%' . $params['search'] . '%')
                    ->orWhere('year', 'like', '%' . $params['search'] . '%')
                    ->orWhere('power_kwh', 'like', '%' . $params['search'] . '%')
                    ->orWhere('capacity', 'like', '%' . $params['search'] . '%');
        });

        if(isset($params['order_by']) && isset($params['order'])) {
            $order = $params['order'] == 'ascending' ? 'asc' : 'desc';
            $datas = $datas->orderBy($params['order_by'] , $order);
        }else {
            $datas = $datas->orderBy('id' , 'desc');
        }

        if(!isset($params['per_page'])) {
            return $datas->get();
        }

        return $datas->paginate($params['per_page']);
    }   
}
