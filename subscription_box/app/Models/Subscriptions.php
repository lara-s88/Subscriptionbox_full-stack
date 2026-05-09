<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
     protected $table = "subscriptions";

     protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'next_billing_date',
        'last_billing_date',
        'pause_until',
        'started_at',
        'renewal_day',
     ];

     public function plan()
     {
        return $this->belongsTo(Plan::class);
     }

     protected function casts(): array
     {
        return [
            'next_billing_date' => 'date',
            'last_billing_date' => 'date',
            'pause_until' => 'date',
            'started_at' => 'date',
        ];
     }
}
