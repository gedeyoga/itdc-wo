<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pompa extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'pompas';

    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'merk',
        'year',
        'type',
        'power_kwh',
        'capacity',
        'status'
    ];


}
