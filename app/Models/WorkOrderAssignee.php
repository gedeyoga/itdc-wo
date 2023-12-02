<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderAssignee extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id' , 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }
}
