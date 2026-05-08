<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Box;
use App\Models\Shipment;

class Order extends Model
{
    protected $table = "box_orders";

    protected $fillable = ['user_id', 'box_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function shipment()
    {
        return $this->hasOne(Shipment::class);
    }
}
