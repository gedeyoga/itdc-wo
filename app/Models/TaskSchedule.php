<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TaskSchedule extends Model
{
    use HasFactory;

    protected $table = 'task_schedules';

    protected $fillable = [
        'task_id' , 'description', 'status' ,'type', 'created_by' , 'updated_by'
    ];


    protected static function boot() {
        parent::boot();

        static::creating(function ($task_schedule) {
            $task_schedule->created_by = Auth::user()->id;
            $task_schedule->updated_by = Auth::user()->id;
        }); 
        static::updating(function ($task_schedule) {
            $task_schedule->updated_by = Auth::user()->id;
        }); 
    }

    public function task()
    {
        return $this->belongsTo(Task::class , 'task_id');
    }

    public function created_user()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function updated_user()
    {
        return $this->belongsTo(User::class , 'updated_by');
    }

    public function days()
    {
        return $this->hasMany(TaskScheduleDay::class , 'task_schedule_id');
    }
    public function months()
    {
        return $this->hasMany(TaskScheduleMonth::class , 'task_schedule_id');
    }
    public function years()
    {
        return $this->hasMany(TaskScheduleYear::class , 'task_schedule_id');
    }

    public function users()
    {
        return $this->hasMany(TaskScheduleUser::class , 'task_schedule_id');
    }
}
