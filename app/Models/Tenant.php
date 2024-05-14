<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tenant extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , SoftDeletes;

    protected $table = 'tenants';

    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'address',
        'phone',
        'virtual_account',
        'bank',
        'npwp'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }
}
