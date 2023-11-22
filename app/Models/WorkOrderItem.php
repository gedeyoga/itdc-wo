<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class WorkOrderItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name', 'work_order_id', 'status', 'has_media'
    ];

    public function work_order()
    {
        return $this->belongsTo(WorkOrder::class , 'work_order_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media')->singleFile();
    }

}
