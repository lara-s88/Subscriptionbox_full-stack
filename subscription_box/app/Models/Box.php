<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = [
        'name',
        'box_type',
        'base_price',
        'base_image',
        'description',
        'weight_kg',
        'is_active',
    ];

    public $timestamps = false;
    
    
    public function items()
{
    return $this->hasMany(BoxItem::class);
}
}