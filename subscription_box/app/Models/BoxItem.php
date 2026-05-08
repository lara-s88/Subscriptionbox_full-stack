<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxItem extends Model
{
    protected $table = "box_items";
    public $timestamps = false;

    protected $fillable = ['box_id', 'inventory_item_id'];
}
