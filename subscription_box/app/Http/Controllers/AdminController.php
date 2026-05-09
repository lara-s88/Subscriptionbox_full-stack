<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

//Models
use App\Models\Plan;
use App\Models\InventoryItem;
use App\Models\Themes as Theme;
use App\Models\ThemesItem;
use App\Models\BoxOrder;
use App\Models\User;
use App\Models\RewardAccount;
use App\Models\RewardItem;
use App\Models\RewardTransaction;
use App\Models\Returns;
use App\Models\ShippingBatch;

class AdminController extends Controller
{
     /* =========================
        0. DASHBOARD
     ========================= */
     public function dashboard()
     {
         $items = InventoryItem::all();
         $users = User::with(['customer', 'subscription.plan', 'rewardAccount'])->get();
         $thresholdItems = InventoryItem::whereColumn('stock_qty', '<=', 'safety_threshold')->get();
         $orders = BoxOrder::with(['user.customer', 'box'])->latest()->get();
         $batches = $orders->where('status', 'packed')
             ->groupBy(fn ($order) => $order->user?->customer?->city ?: 'Unassigned')
             ->map(function ($orders) {
                 $firstOrder = $orders->first();
                 $region = $firstOrder->user?->customer?->city ?: 'Unassigned';

                 return [
                     'batch_id' => $region,
                     'region' => $region,
                     'orders_count' => $orders->count(),
                 ];
             });
         $returns = Returns::with('order')->get();
         $themes = Theme::with('items.inventoryItem')->get();

         return view('adminDashboared', compact(
             'items',
             'users',
             'thresholdItems',
             'orders',
             'batches',
             'returns',
             'themes'
         ));
     }

     public function showDashboard()
     {
         return $this->dashboard();
     }

     /* =========================
        1. PLAN MANAGEMENT
     ========================= */


      // Create a new plan
public function createPlan(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|unique:plans,name',
            'price_monthly'  => 'required|numeric|min:0',
            'boxes_per_month'=> 'nullable|integer|min:1',
            'swap_limit'     => 'nullable|integer|min:0',
            'express_shipping'=> 'nullable|boolean',
            'early_access'   => 'nullable|boolean',
            'vip_support'    => 'nullable|boolean',
        ]);
        $plan = Plan::create($request->all());

        return redirect()->back()
         ->with('success', 'Plan created successfully.');

    }
    
     // Delete a plan by ID
       public function deletePlan($planId){
        $plan = Plan::findOrFail($planId);
        $plan->delete();

        return redirect()->back()
            ->with('success', 'Plan deleted successfully');
       }
     
    // Get all plans
    public function getAllPlans()
    {
        $plans = Plan::all();

        return view('plans', compact('plans'));
    }


    /* =========================
       2. INVENTORY MANAGEMENT
    ========================= */
          // Add a new inventory item
    public function addItem(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'category'   => 'required|string|max:80',
            'unit_price' => 'required|numeric|min:1',
            'stock_qty'  => 'required|integer|min:1',
            'safety_threshold' => 5,
            'weight_kg'  => 'nullable|numeric|min:1',
        ]);
        $item = InventoryItem::create($request->all());

        return redirect()->back()
         ->with('success', 'Item added successfully.');

    }
      
    // Delete an inventory item by ID
      public function deleteItem($itemId){
        $item = InventoryItem::findorFail($itemId);
        $item->delete();

        return redirect()->back()
         ->with('success', 'Item deleted successfully.');   
      }

    // Get all inventory items
    public function getAllItems(){
        $items = InventoryItem::all();

        return view('items', compact('items'));
    }
   

    // Update the stock quantity of an item
     public function updateStock(Request $request, $itemId){
        $request->validate([
            'stock_qty' => 'required|integer',
        ]);
        $item = InventoryItem::findOrFail($itemId);
        $item->stock_qty = $request->stock_qty;
        $item->save();

        return redirect()->back()
         ->with('success', 'Stock updated successfully.');
     }

     // Get items that are below or equal to their safety threshold
       public function getThresholdItems(){
         $items = InventoryItem::whereColumn('stock_qty', '<=', 'safety_threshold')->get();

        return view('adminDashboared', compact('items'));
       }


       /* =========================
       3. THEME (MONTHLY BOX)
    ========================= */

    // Create a new theme  
    public function createTheme(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|unique:themes,name',
            'month'       => 'required|integer|min:1|max:12',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|string',
        ]);

        $theme = Theme::create($request->all());
        return redirect()->back()
         ->with('success', 'Theme created successfully.');
         
         }

    // Delete a theme by ID
    public function deleteTheme($themeId)
    {
        $theme = Theme::findOrFail($themeId);
        $theme->delete();
        return redirect()->back()
         ->with('success', 'Theme deleted successfully.');
     }

    // Assign an item to a theme
       public function assignItemToTheme(Request $request)
    {
        $request->validate([
            'theme_id'=> 'required|exists:themes,id',
            'inventory_item_id' => 'required|exists:inventory_items,id',
        ]);

        $alreadyExists = ThemesItem::where('theme_id', $request->theme_id)
            ->where('inventory_item_id', $request->inventory_item_id)
            ->exists();

        if ($alreadyExists) {
            return redirect()->back()
                ->with('error', 'Item is already assigned to this theme');
        }

        ThemesItem::create([
            'theme_id'=> $request->theme_id,
            'inventory_item_id' => $request->inventory_item_id,
        ]);
         
        return redirect()->back()
         ->with('success', 'Item assigned to theme successfully.');
         }


         // Remove an inventory item from a theme

          public function removeItemFromTheme($themeId, $itemId)
        {
        $themeItem = ThemesItem::where('theme_id', $themeId)
            ->where('inventory_item_id', $itemId)
            ->firstOrFail();

        $themeItem->delete();

        return redirect()->back()
            ->with('success', 'Item removed from theme successfully');
        }

    /* =========================
       4. ORDERS & FULFILLMENT
    ========================= */
    // Get all orders
    public function getAllOrders()
    {
        $orders = BoxOrder::with(['user', 'box'])->get();

        return view('adminDashboared', compact('orders'));
    }

    // Get a single order by ID
    public function getOrder($orderId)
    {
        $order = BoxOrder::with(['user', 'box'])->findOrFail($orderId);

        return redirect()->back()
         ->with('success', 'Order retrieved successfully.');
}

    // Update the status of an order
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,packed,shipped,out_for_delivery,delivered,returned',
        ]);

        $order = BoxOrder::findOrFail($orderId);
        $order->status = $request->status;
        $order->save();
        return redirect()->back()
         ->with('success', 'Order status updated successfully.');

}
     // get orders Batching
     public function getOrdersForBatching()
{
    $batches = BoxOrder::where('status', 'packed')
        ->whereHas('shipment.batch')
        ->with(['shipment.batch'])
        ->get()
        ->groupBy(fn ($order) => $order->shipment->batch->id)
        ->map(function ($orders) {

            $firstOrder = $orders->first();
            $batch = $firstOrder->shipment->batch;

            return [
                'batch_id' => $batch->id,
                'region' => $batch->city,
                'orders_count' => $orders->count(),
            ];
        });

    return view('adminDashboared', compact('batches'));
}

/* =========================
       5. USER MANAGEMENT
    ========================= */

// Get all users
    public function getAllUsers()
    {
        $users = User::all();

        return view('adminDashboared', compact('users'));
    }
   // Get a single user by ID
    public function getUserById($userId)
    {
    
        $user = User::with(['customer', 'subscription','favorite_theme'])->findOrFail($userId);

        return view('adminDashboared', compact('user'));
    }


/* =========================
       6. REWARDS
    ========================= */

    // Show all reward accounts and their points
    public function getAllRewardAccounts()
    {
        $rewardAccounts = RewardAccount::with(['user', 'transactions'])->get();
        $rewardItems = RewardItem::orderBy('points')->get();

        return view('adminReward', compact('rewardAccounts', 'rewardItems'));
    }

    //add reward points for an order

    public function addRewardPointsForOrder($orderId)
{
    $order = BoxOrder::findOrFail($orderId);
    $this->awardRewardPointsForOrder($order);

    return redirect()->back()
        ->with('success', 'Reward points added successfully.');
}

public function awardRewardPointsForOrder(BoxOrder $order, int $points = 10): RewardAccount
{
    return DB::transaction(function () use ($order, $points) {
        $rewardAccount = RewardAccount::firstOrCreate(
            ['user_id' => $order->user_id],
            ['points' => 0, 'tier_name' => 'Bronze']
        );

        $rewardAccount->increment('points', $points);
        $rewardAccount->refresh();

        $this->updateRewardTier($rewardAccount);

        $transactionData = [
            'user_id' => $order->user_id,
            'points_used' => $points,
        ];

        if (Schema::hasColumn('reward_transactions', 'type')) {
            $transactionData['type'] = 'earned';
        }

        RewardTransaction::create($transactionData);

        return $rewardAccount;
    });
}

private function updateRewardTier(RewardAccount $rewardAccount): void
{
    if ($rewardAccount->points >= 500) {
        $rewardAccount->tier_name = 'Gold';
    }
    elseif ($rewardAccount->points >= 100) {
        $rewardAccount->tier_name = 'Silver';
    }
    else {
        $rewardAccount->tier_name = 'Bronze';
    }

    $rewardAccount->save();
}


// Redeem reward points
public function redeemRewardPoints(Request $request, $userId)
{
    $request->validate([
        'points_to_redeem' => 'required|integer|min:1'
    ]);

    $rewardAccount = RewardAccount::where('user_id', $userId)
        ->firstOrFail();

    // Check if enough points exist
    if ($rewardAccount->points < $request->points_to_redeem) {
        return redirect()->back()
            ->with('error', 'Insufficient reward points.');
    }

    // Decrease points
    $rewardAccount->decrement('points', $request->points_to_redeem);

    // Refresh updated values
    $rewardAccount->refresh();

    $this->updateRewardTier($rewardAccount);

    // Record transaction
    $transactionData = [
        'user_id' => $userId,
        'points_used' => $request->points_to_redeem,
    ];

    if (Schema::hasColumn('reward_transactions', 'type')) {
        $transactionData['type'] = 'redeemed';
    }

    RewardTransaction::create($transactionData);

    return redirect()->back()
        ->with('success', 'Points redeemed successfully.');
}

     /* =========================
       7. RETURNS
    ========================= */

    // Get all return requests
    public function getAllReturns()
    {
        $returns = Returns::with('order')->get();

        return view('adminDashboared', compact('returns'));
    
    }
    
    // Get a single return request by ID
    public function getReturnById($returnsId)
    {
        $return = Returns::with('order')->findOrFail($returnsId);

        return view('adminDashboared', compact('return'));
    }
    //Approve or reject a return request
    public function handleReturn(Request $request, $returnsId)
          {
    $return = Returns::findOrFail($returnsId);

    if ($return->status != 'pending') {
        return redirect()->back()
            ->with('error', 'This return request was already processed.');
    }

    if (!$return->image) {
        return redirect()->back()
            ->with('error', 'No proof image uploaded.');
    }

    $request->validate([
        'action' => 'required|in:approved,rejected',
    ]);

    $return->status = $request->action;

    $return->save();

    return redirect()->route('admin.dashboard', $returnsId)
        ->with('success', 'Return request updated successfully.');
}

}
 

 
