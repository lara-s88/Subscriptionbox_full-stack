<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Returns extends Model
{
    protected $table = "returns";
    public $timestamps = false;

    protected $fillable = ['order_id', 'reason', 'status', 'photo_path'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
