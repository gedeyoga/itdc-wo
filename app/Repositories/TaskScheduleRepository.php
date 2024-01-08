<?php 

namespace App\Repositories;

use App\Models\TaskSchedule;
use App\Models\User;

interface TaskScheduleRepository {

    public function list(array $params);

    public function createSchedule(array $data , $times = []);
    
    public function updateSchedule(TaskSchedule $task_schedule, array $data , $times = []);

    public function scheduleUser(TaskSchedule $task_schedule, array $user_ids);
    
    
}