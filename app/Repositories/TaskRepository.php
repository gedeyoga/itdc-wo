<?php 

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;

interface TaskRepository {
    
    public function createTask(array $data, array $items);

    public function updateTask( Task $task ,array $data, array $items);

    public function list(array $params);

}