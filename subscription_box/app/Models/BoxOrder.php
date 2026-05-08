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
    'total_amount',
    'clothing_size',
    'diet_preference',
    'delivery_frequency'
    ];
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     /**
     * علاقة الطلب بالبوكس (كل أوردر مرتبط بنوع بوكس معين)
     */
    public function box()
    {
        return $this->belongsTo(Box::class, 'box_id');
    }
}