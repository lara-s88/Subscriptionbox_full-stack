<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxOrder extends Model
{
     protected $table = "box_orders";

protected $fillable = [
    'user_id',
    'box_id',
    'order_number',
    'status',
    'total_amount'
];
}