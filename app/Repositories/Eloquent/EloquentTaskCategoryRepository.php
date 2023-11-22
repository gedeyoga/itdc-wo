<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\TaskCategoryRepository;

class EloquentTaskCategoryRepository extends EloquentBaseRepository implements TaskCategoryRepository
{
    public function list(array $params)
    {
        $datas = $this->model
        
        ->when(isset($params['search']), function($q) use ($params) {
            return $q->where('name' ,'like', '%'.$params['search'].'%');
        })
        
        ->orderBy('created_at', 'desc');

        if(!isset($params['per_page'])) {
            return $datas->get();
        }

        return $datas->paginate($params['per_page']);
    }   
}
