<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetMaster extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function asset_parameters()
    {
        return $this->hasMany(AssetMasterParameter::class , 'asset_id');
    }
}
