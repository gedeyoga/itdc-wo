<?php 

namespace App\Repositories;

use App\Models\Task;
use App\Models\User;

interface PompaRepository {
    
   public function list(array $params);

}