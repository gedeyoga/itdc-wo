<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPompa extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_installation_id',
        'work_order_attachment_id',
        'before',
        'after',
        'selisih',
        'capacity'
    ];

    public function location()
    {
        return $this->belongsTo(LocationInstallation::class , 'location_installation_id');
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrderAttachment::class , 'work_order_attachment_id');
    }
}
