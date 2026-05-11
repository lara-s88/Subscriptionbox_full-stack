<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    protected $table = "returns";
    public $timestamps = false;

    protected $fillable = ['order_id', 'reason', 'status', 'photo_path', 'image'];

    public function getImageAttribute(): ?string
    {
        return $this->photo_path;
    }

    public function setImageAttribute(?string $value): void
    {
        $this->attributes['photo_path'] = $value;
    }

    public function order()
    {
        return $this->belongsTo(BoxOrder::class, 'order_id');
    }
}
