<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model 
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'diet_preference',
        'delivery_frequency',
        'clothing_size',
        'address',
        'city',
        'country',
        'delivery_instructions',
    ];

    
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}