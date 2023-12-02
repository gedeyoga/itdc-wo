<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorkOrderLog extends Model
{
    use HasFactory;

    protected $table = 'work_order_log';
    protected $fillable = [
        'work_order_id','log', 'created_by'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($log) {;
            $log->created_by = Auth::user()->id;
        });
    }

    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class , 'created_by');
    }


}
