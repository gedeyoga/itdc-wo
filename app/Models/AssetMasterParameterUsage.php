<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetMasterParameterUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'asset_parameter_id',
        'work_order_attachment_id',
        'before',
        'after',
        'selisih',
    ];

    public function asset_master()
    {
        return $this->belongsTo(AssetMaster::class , 'asset_id');
    }

    public function asset_parameter()
    {
        return $this->belongsTo(AssetMasterParameter::class, 'asset_parameter_id');
    }
    
    public function work_order_attachment()
    {
        return $this->belongsTo(WorkOrderAttachment::class , 'work_order_attachment_id');
    }
}
