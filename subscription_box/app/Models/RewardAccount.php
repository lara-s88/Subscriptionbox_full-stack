<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardAccount extends Model
{
    protected $table = "reward_accounts";
    public $timestamps = false;

    protected $fillable = ['user_id', 'points', 'tier_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(RewardTransaction::class, 'user_id', 'user_id');
    }
}

