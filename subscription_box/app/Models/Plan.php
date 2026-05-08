<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = "plans";
     protected $fillable = [
        'name',
        'price_monthly',
        'boxes_per_month',
        'swap_limit',
        'express_shipping',
        'early_access',
        'vip_support',
    ];

    public $timestamps = false;
}
