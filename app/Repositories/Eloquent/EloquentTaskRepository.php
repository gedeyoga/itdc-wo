<?php

namespace App\Repositories\Eloquent;

use App\Models\Task;
use App\Repositories\TaskRepository;

class EloquentTaskRepository extends EloquentBaseRepository implements TaskRepository
{

    public function createTask(array $data, array $items)
    {
        $task = $this->create($data);

        $task->task_items()->createMany($items);

        return $task;
    }

    public function updateTask(Task $task, array $data, array $items)
    {
        $model = $this->update($task , $data);

        $model->task_items()->delete();

        $model->task_items()->createMany($items);

        return $model;
    }

    public function list(array $params)
    {
        $datas = $this->model

        ->when(isset($params['relations']) , function($q) use ($params) {
            $relations = explode(',', $params['relations']);
            return $q->with($relations);
        })
        
        ->when(isset($params['priority_id']) , function($q) use ($params) {
            return $q->where('priority_id' , $params['priority_id']);
        })

        ->when(isset($params['task_category_id']) , function($q) use ($params) {
            return $q->where('task_category_id', $params['task_category_id']);
        })

        ->orderBy('created_at', 'desc');

        if(!isset($params['per_page'])) {
            return $datas->get();
        }

        return $datas->paginate($params['per_page']);

    }
    
}
