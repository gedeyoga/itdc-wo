<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskScheduleUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_schedule_id' , 'user_id'
    ];
    
}
