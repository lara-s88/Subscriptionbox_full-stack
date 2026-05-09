<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxItem extends Model
{
    protected $table = "box_items";
    public $timestamps = false;

    protected $fillable = ['box_id', 'inventory_item_id'];


    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
