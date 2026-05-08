<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
  protected $table = "inventory_items";
  protected $fillable = [
      'name',
      'category',
      'stock_qty',
      'safety_threshold',
      'unit_price',
      'weight_kg',
  ];
  public $timestamps = false;

  public function themes()
  {
      return $this->belongsToMany(Themes::class, 'themes_items', 'inventory_item_id', 'theme_id');
  }
}
