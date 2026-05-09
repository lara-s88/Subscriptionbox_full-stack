<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxOrder extends Model
{
    protected $fillable = [
        'user_id',
        'box_id',
        'order_number',
        'status',
        'total_amount'
    ];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}