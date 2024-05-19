<?php

namespace App\Models;

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

    public function history_pompa()
    {
        return $this->hasOne(HistoryPompa::class , 'work_order_attachment_id');
    }
    
}
