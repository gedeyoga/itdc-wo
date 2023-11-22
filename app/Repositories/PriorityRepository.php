<?php 

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;

interface PriorityRepository {
    
   public function list(array $params);

}