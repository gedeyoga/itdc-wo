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

    protected $fillable = [
        'code','name', 'description', 'task_category_id' , 'priority_id','status','date','start_at', 'start_by','finish_at','finish_by','created_by'
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

        static::creating(function($work_order) {;
            $work_order->created_by = Auth::user()->id;
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

    public function start_by()
    {
        return $this->belongsTo(User::class);
    }

    public function finish_by()
    {
        return $this->belongsTo(User::class);
    }

    public function work_order_items()
    {
        return $this->hasMany(WorkOrderItem::class , 'work_order_id');
    }
}
