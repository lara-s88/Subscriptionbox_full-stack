<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardTransaction extends Model
{
    protected $table = "reward_transactions";
    public $timestamps = false;

    protected $fillable = ['user_id', 'points_used', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
