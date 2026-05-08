<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\ShippingBatch;

class Shipment extends Model
{
    public $timestamps = false;

    protected $fillable = ['order_id', 'batch_id', 'tracking_code', 'carrier_name', 'status', 'estimated_delivery', 'stops_away'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function batch()
    {
        return $this->belongsTo(ShippingBatch::class);
    }
}
