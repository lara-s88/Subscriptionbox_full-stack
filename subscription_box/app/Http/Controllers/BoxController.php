<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\BoxItem;
use App\Models\InventoryItem;
use App\Models\CartItem;
use App\Models\CartItemExtra;

class BoxController extends Controller
{
    //1-show Box
    public function showBox($boxId)
    {
        $box = Box::with('items,inventoryItem')->find($boxId);
        if(!$box){ 
            return response()->json(['message' => 'Box not found'] , 404);
        }
        return response()->json($box);

    }

   //2- Customization Options
   public function customizationOptions($boxId)
    {
        $box = Box::find($boxId);
        if(!$box){
            return response()->json(['message' => 'Box not found'] , 404);
        }
        $items = InventoryItem::where('theme_id', $box->theme_id)
                ->where('stock_qty', '>',0)
                ->get();

        return response()->json($items);


   }

   //3-Swap Item
   public function swapItem(Request $request)
   {
    $request->validate([
        'cart_item_id' => 'required|exists:cart_items,id',
        'old_item_id' => 'required',
        'new_item_id' => 'required'
    ]);
    $cartItem = CartItem::find($request->cart_item_id);
    
    //check lock
    if($cartItem->shipping_status === 'shipping_confirmed'){
        return response()->json(['message' => 'Box locked'], 400);
    }
    $newItem = InventoryItem::find($request->new_item_id);

    if(!$newItem || $newItem->stock_qty <= 0){
        return response()->json(['message' => 'Item not available'], 400);

    }

    //remove Old Item
    CartItemExtra::where('cart_item_id', $cartItem->id)
            ->where('inventory_item_id', $request->old_item_id)
            ->delete();

   // add New Item
   CartItemExtra::create([
    'cart_item_id' => $cartItem->id,
    'inventory_item_id' =>$newItem->id,
    'item_name' => $newItem->name,
    'source_type' => 'swap',
    'unit_price' => $newItem->unit_price

   ]);
      return response()->json(['message' => 'Swap success']);

   }
}
