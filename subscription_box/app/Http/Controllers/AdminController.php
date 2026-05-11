<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Models
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

class AdminController extends Controller
{
    /* =========================
       0. DASHBOARD
    ========================= */

    // Load all data needed for the admin dashboard view
    public function dashboard()
    {
        $items         = InventoryItem::all();
        $users         = User::with(['customer', 'subscription.plan', 'rewardAccount'])->get();
        $thresholdItems = InventoryItem::whereColumn('stock_qty', '<=', 'safety_threshold')->get();
        $orders        = BoxOrder::with(['user.customer', 'box'])->latest()->get();
        $returns       = Returns::with('order')->get();
        $themes        = Theme::with('items.inventoryItem')->get();

        // Group packed orders by city to form shipping batches
        $batches = $orders->where('status', 'packed')
            ->groupBy(fn($order) => $order->user?->customer?->city ?: 'Unassigned')
            ->map(fn($orders, $region) => [
                'batch_id'     => $region,
                'region'       => $region,
                'orders_count' => $orders->count(),
            ]);

        return view('adminDashboared', compact(
            'items', 'users', 'thresholdItems',
            'orders', 'batches', 'returns', 'themes'
        ));
    }

    /* =========================
       1. PLAN MANAGEMENT
    ========================= */

    // Create a new subscription plan
    public function createPlan(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|unique:plans,name',
            'price_monthly'   => 'required|numeric|min:0',
            'boxes_per_month' => 'nullable|integer|min:1',
            'swap_limit'      => 'nullable|integer|min:0',
            'express_shipping' => 'nullable|boolean',
            'early_access'    => 'nullable|boolean',
            'vip_support'     => 'nullable|boolean',
        ]);

        Plan::create($request->all());

        return redirect()->back()->with('success', 'Plan created successfully.');
    }

    // Delete a plan by its ID
    public function deletePlan($planId)
    {
        Plan::findOrFail($planId)->delete();

        return redirect()->back()->with('success', 'Plan deleted successfully.');
    }

    // Show all plans
    public function getAllPlans()
    {
        return view('plans', ['plans' => Plan::all()]);
    }

    /* =========================
       2. INVENTORY MANAGEMENT
    ========================= */

    // Add a new item to inventory
    public function addItem(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'category'         => 'required|string|max:80',
            'unit_price'       => 'required|numeric|min:1',
            'stock_qty'        => 'required|integer|min:1',
            'safety_threshold' => 'nullable|integer|min:0',
            'weight_kg'        => 'nullable|numeric|min:0',
        ]);

        InventoryItem::create($request->all());

        return redirect()->back()->with('success', 'Item added successfully.');
    }

    // Delete an inventory item by its ID
    public function deleteItem($itemId)
    {
        InventoryItem::findOrFail($itemId)->delete();

        return redirect()->back()->with('success', 'Item deleted successfully.');
    }

    // Show all inventory items
    public function getAllItems()
    {
        return view('items', ['items' => InventoryItem::all()]);
    }

    // Update the stock quantity of a specific item
    public function updateStock(Request $request, $itemId)
    {
        $request->validate([
            'stock_qty' => 'required|integer|min:0',
        ]);

        InventoryItem::findOrFail($itemId)->update(['stock_qty' => $request->stock_qty]);

        return redirect()->back()->with('success', 'Stock updated successfully.');
    }

    /* =========================
       3. THEME (MONTHLY BOX)
    ========================= */

    // Create a new monthly box theme
    public function createTheme(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|unique:themes,name',
            'month'       => 'required|integer|min:1|max:12',
            'description' => 'nullable|string',
            'image_url'   => 'nullable|string',
        ]);

        Theme::create($request->all());

        return redirect()->back()->with('success', 'Theme created successfully.');
    }

    // Delete a theme by its ID
    public function deleteTheme($themeId)
    {
        Theme::findOrFail($themeId)->delete();

        return redirect()->back()->with('success', 'Theme deleted successfully.');
    }

    // Assign an inventory item to a theme (no duplicates allowed)
    public function assignItemToTheme(Request $request)
    {
        $request->validate([
            'theme_id'          => 'required|exists:themes,id',
            'inventory_item_id' => 'required|exists:inventory_items,id',
        ]);

        $alreadyExists = ThemesItem::where('theme_id', $request->theme_id)
            ->where('inventory_item_id', $request->inventory_item_id)
            ->exists();

        if ($alreadyExists) {
            return redirect()->back()->with('error', 'Item is already assigned to this theme.');
        }

        ThemesItem::create($request->only('theme_id', 'inventory_item_id'));

        return redirect()->back()->with('success', 'Item assigned to theme successfully.');
    }

    // Remove an inventory item from a theme
    public function removeItemFromTheme($themeId, $itemId)
    {
        ThemesItem::where('theme_id', $themeId)
            ->where('inventory_item_id', $itemId)
            ->firstOrFail()
            ->delete();

        return redirect()->back()->with('success', 'Item removed from theme successfully.');
    }

    /* =========================
       4. ORDERS & FULFILLMENT
    ========================= */

    // Update the status of a specific order
    public function updateOrderStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,packed,shipped,out_for_delivery,delivered,returned',
        ]);

        BoxOrder::findOrFail($orderId)->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    /* =========================
       5. USER MANAGEMENT
    ========================= */

    // Get a single user with their profile, subscription, and favourite theme
    public function getUserById($userId)
    {
        $user = User::with(['customer', 'subscription', 'favorite_theme'])->findOrFail($userId);

        return view('adminDashboared', compact('user'));
    }

    /* =========================
       6. REWARDS
    ========================= */

    // Show all reward accounts and available reward items
    public function getAllRewardAccounts()
    {
        $rewardAccounts = RewardAccount::with(['user', 'transactions'])->get();
        $rewardItems    = RewardItem::orderBy('points')->get();

        return view('adminReward', compact('rewardAccounts', 'rewardItems'));
    }

    // Manually trigger reward points for a specific order (called from the admin panel)
    public function addRewardPointsForOrder($orderId)
    {
        $order = BoxOrder::findOrFail($orderId);
        $this->awardRewardPointsForOrder($order);

        return redirect()->back()->with('success', 'Reward points added successfully.');
    }

    // Award points to a user's reward account for a completed order.
    // Also creates a transaction record and updates the user's tier.
    // This is public so CustomerController can call it when confirming shipping.
    public function awardRewardPointsForOrder(BoxOrder $order, int $points = 10): RewardAccount
    {
        return DB::transaction(function () use ($order, $points) {
            // Get or create the reward account for this user
            $rewardAccount = RewardAccount::firstOrCreate(
                ['user_id' => $order->user_id],
                ['points' => 0, 'tier_name' => 'Bronze']
            );

            $rewardAccount->increment('points', $points);
            $rewardAccount->refresh();

            $this->updateRewardTier($rewardAccount);

            // Build transaction data (handle optional 'type' column)
            $transactionData = ['user_id' => $order->user_id, 'points_used' => $points];
            if (Schema::hasColumn('reward_transactions', 'type')) {
                $transactionData['type'] = 'earned';
            }

            RewardTransaction::create($transactionData);

            return $rewardAccount;
        });
    }



    // Update the reward tier (Bronze / Silver / Gold) based on total points
    private function updateRewardTier(RewardAccount $rewardAccount): void
    {
        $rewardAccount->tier_name = match(true) {
            $rewardAccount->points >= 500 => 'Gold',
            $rewardAccount->points >= 100 => 'Silver',
            default                       => 'Bronze',
        };

        $rewardAccount->save();
    }

    /* =========================
       7. RETURNS
    ========================= */

    // Approve or reject a pending return request
    public function handleReturn(Request $request, $returnsId)
    {
        $return = Returns::findOrFail($returnsId);

        if ($return->status !== 'pending') {
            return redirect()->back()->with('error', 'This return request was already processed.');
        }

        if (!$return->image) {
            return redirect()->back()->with('error', 'No proof image uploaded.');
        }

        $request->validate([
            'action' => 'required|in:approved,rejected',
        ]);

        $return->update(['status' => $request->action]);

        return redirect()->route('admin.dashboard')->with('success', 'Return request updated successfully.');
    }
}