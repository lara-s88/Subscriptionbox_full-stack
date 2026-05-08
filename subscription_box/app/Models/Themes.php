<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Themes extends Model
{
    protected $table = "themes";

    protected $fillable = ['name', 'month', 'description', 'image_url'];

    public function items() {
    return $this->hasMany(ThemesItem::class, 'theme_id');
    }
    public function inventoryItems()
    {
        return $this->belongsToMany(InventoryItem::class, 'themes_items', 'theme_id', 'inventory_item_id');
    }
}
