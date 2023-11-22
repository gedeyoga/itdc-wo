<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name','description','task_category_id','priority_id'
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

}
