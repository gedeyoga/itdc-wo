<?php

namespace App\Models;

use App\Http\Resources\AssetMasterParameterUsageResource;
use App\Http\Resources\AssetMasterResource;
use App\Http\Resources\HistoryPompaResource;
use App\Http\Resources\LocationInstallationResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrderAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order_id',
        'attach_id',
        'attach_type'
    ];

    protected $appends = ['attachment' , 'attachment_datas'];
    protected $attach_types = [
        'asset_master' => [
            'model' => [
                'class' => AssetMaster::class,
                'load' => ['asset_parameters'],
                'resources' => AssetMasterResource::class,
            ],
            'data' => [
                'class' => AssetMasterParameterUsage::class,
                'load' => ['asset_parameter'],
                'resources' => AssetMasterParameterUsageResource::class,
            ]
        ],
        'location_installation' => [
            'model' => [
                'class' => LocationInstallation::class,
                'load' => [],
                'resources' => LocationInstallationResource::class,
            ],
            'data' => [
                'class' => HistoryPompa::class,
                'load' => ['location'],
                'resources' => HistoryPompaResource::class,
            ]
        ]
    ];

    public function history_pompa()
    {
        return $this->hasOne(HistoryPompa::class , 'work_order_attachment_id');
    }

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id');
    }

    public function getAttachmentAttribute()
    {
        $data = $this->belongsTo($this->attach_types[$this->attach_type]['model']['class'], 'attach_id')->with($this->attach_types[$this->attach_type]['model']['load'])->first();
        return new $this->attach_types[$this->attach_type]['model']['resources']($data);
    }

    public function getAttachmentDatasAttribute()
    {
        $datas = $this->hasMany($this->attach_types[$this->attach_type]['data']['class'], 'work_order_attachment_id')->with($this->attach_types[$this->attach_type]['data']['load'])->get();
        return $this->attach_types[$this->attach_type]['data']['resources']::collection($datas);
    }
    
}
