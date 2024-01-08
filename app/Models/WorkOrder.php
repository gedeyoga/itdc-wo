<?php

namespace App\Models;

use Alfa6661\AutoNumber\AutoNumberTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorkOrder extends Model
{
    use HasFactory, AutoNumberTrait;

    protected $table = 'work_orders';
    
    protected $fillable = [
        'code','name', 'description', 'task_category_id' , 'priority_id','status','date','start_at', 'start_by','finish_at','finish_by','created_by','location_id'
    ];

    public function getAutoNumberOptions()
    {
        return [
            'code' => [
                'format' => 'WO/'.date('Y/m') . '/?', // autonumber format. '?' will be replaced with the generated number.
                'length' => 3 // The number of digits in an autonumber
            ]
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function($work_order) {
            $user = Auth::user();
            if(!is_null($user)) {
                $work_order->created_by = $user->id;
            }
        }); 
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function task_category()
    {
        return $this->belongsTo(TaskCategory::class);
    }

    public function user_started()
    {
        return $this->belongsTo(User::class , 'start_by');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class , 'created_by');
    }

    public function user_finished()
    {
        return $this->belongsTo(User::class , 'finish_by');
    }

    public function work_order_items()
    {
        return $this->hasMany(WorkOrderItem::class , 'work_order_id');
    }

    public function assignees()
    {
        return $this->hasMany(WorkOrderAssignee::class, 'work_order_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function work_order_logs()
    {
        return $this->hasMany(WorkOrderLog::class , 'work_order_id')->orderBy('id', 'desc');
    }
}
