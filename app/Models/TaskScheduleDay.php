<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskScheduleDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_schedule_id', 'day', 'hour'
    ];

    public function task_schedule()
    {
        return $this->belongsTo(TaskSchedule::class , 'task_schedule_id');
    }
}
