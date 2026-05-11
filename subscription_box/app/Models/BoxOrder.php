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
     
protected static function booted(): void
    {
        static::creating(function (BoxOrder $order) {
            if ((!$order->box_name || !$order->total_amount) && $order->box_id) {
                $box = Box::find($order->box_id);

                if ($box) {
                    $order->box_name = $order->box_name ?: $box->name;
                    $order->total_amount = $order->total_amount ?: $box->base_price;
                }
            }
        });
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
