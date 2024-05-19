<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Task extends Model implements HasMedia
{
    use HasFactory, SoftDeletes , InteractsWithMedia;

    protected $fillable = [
        'name','description','task_category_id','priority_id', 'location_id', 'fill_history_pompa'
    ];

    public static function boot()
    {
        parent::boot();
        
    }

    public function task_items()
    {
        return $this->hasMany(TaskItem::class, 'task_id');
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function task_category()
    {
        return $this->belongsTo(TaskCategory::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('barcode')->singleFile();
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function task_attachments()
    {
        return $this->hasMany(TaskAttachment::class , 'task_id');
    }

    public function task_attachment_location_installation() 
    {
        return $this->task_attachments()->where('attach_type' , 'installation_location');
    }
    


}
