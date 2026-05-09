<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxOrder extends Model
{
    protected $fillable = [
        'user_id',
        'customer_id',
        'box_id',
        'order_number',
        'box_name',
        'base_price',
        'status',
        'total_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
