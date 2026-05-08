<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThemesItem extends Model
{
    protected $table = "themes_items";

    protected $fillable = ['theme_id', 'inventory_item_id'];

    public function theme() {
    return $this->belongsTo(Themes::class, 'theme_id');
}

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }
}
