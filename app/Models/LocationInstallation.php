<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocationInstallation extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'location_installations';

    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'location_id',
        'pompa_id',
        'jenis_pompa',
        'status',
    ];

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    
    public function pompa()
    {
        return $this->belongsTo(Pompa::class, 'pompa_id');
    }
}
