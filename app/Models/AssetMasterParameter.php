<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMasterParameter extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'asset_id',
        'label',
        'satuan',
        'has_image'
    ];

    public function asset_master()
    {
        return $this->belongsTo(AssetMaster::class , 'asset_id');
    }

    public function asset_usages()
    {
        return $this->hasMany(AssetMasterParameterUsage::class , 'asset_parameter_id');
    }

    public function latest_usage()
    {
        return $this->hasOne(AssetMasterParameterUsage::class , 'asset_parameter_id')->orderBy('id', 'desc');;
    }
}
