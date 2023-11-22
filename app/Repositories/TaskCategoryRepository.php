<?php 

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;

interface TaskCategoryRepository {
    
   public function list(array $params);

}