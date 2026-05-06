<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    public function items() 
    {
        return $this->hasMany(BoxItem::class);

    }
}
