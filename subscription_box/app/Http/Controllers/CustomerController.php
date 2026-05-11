<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Customer;
use App\Models\User;
use App\Models\Box;
use App\Models\BoxOrder;
use App\Models\InventoryItem;
use App\Models\RewardAccount;
use App\Models\RewardItem;
use App\Models\RewardTransaction;
use App\Models\Subscription;
use App\Models\Themes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CustomerController extends Controller
{
    /* =========================
       1. SUBSCRIPTION MANAGEMENT
    ========================= */

    // Select or change a subscription plan (upgrade / downgrade).
    // Accepts either plan_id or plan_name from the form.
    public function selectPlan(Request $request)
    {
        $request->validate([
            'plan_id'   => 'required_without:plan_name|exists:plans,id',
            'plan_name' => 'required_without:plan_id|exists:plans,name',
        ]);

        // Find the plan by whichever field was provided
        $plan = $request->filled('plan_id')
            ? Plan::findOrFail($request->plan_id)
            : Plan::where('name', $request->plan_name)->firstOrFail();

        // Update or create the customer record with the new plan
        $customerValues = [];
        if (Schema::hasColumn('customers', 'plan_id')) {
            $customerValues['plan_id'] = $plan->id;
        }
        Customer::updateOrCreate(['user_id' => Auth::id()], $customerValues);

        // Update or create the subscription record
        Subscription::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'plan_id'           => $plan->id,
                'status'            => 'active',
                'last_billing_date' => now()->toDateString(),
                'next_billing_date' => now()->addMonth()->toDateString(),
                'pause_until'       => now()->toDateString(),
                'started_at'        => now()->toDateString(),
                'renewal_day'       => now()->day,
            ]
        );

        return redirect()->route('dashboard');
    }

    // Pause the logged-in user's subscription for 1–3 months
    public function pauseSubscription(Request $request)
    {
        $user = $this->getAuthUser($request);
        if (!$user) {
            return $this->subscriptionResponse($request, false, 'Please sign in first.', 401);
        }

        $validated     = $request->validate(['months' => 'nullable|integer|min:1|max:3']);
        $subscription  = Subscription::where('user_id', $user->id)->first();

        if (!$subscription) {
            return $this->subscriptionResponse($request, false, 'Please choose a plan before pausing.', 404);
        }

        if ($subscription->status === 'paused') {
            return $this->subscriptionResponse($request, false, 'Subscription is already paused.');
        }

        $months = $validated['months'] ?? 1;
        $subscription->update([
            'status'      => 'paused',
            'pause_until' => now()->addMonths($months)->toDateString(),
        ]);

        $pauseDate = $subscription->fresh()->pause_until->format('M d, Y');

        return $this->subscriptionResponse(
            $request, true,
            "Subscription paused until {$pauseDate}.",
            200,
            ['subscription' => $subscription->fresh('plan')]
        );
    }

    // Resume a paused subscription
    public function resumeSubscription(Request $request)
    {
        $user = $this->getAuthUser($request);
        if (!$user) {
            return $this->subscriptionResponse($request, false, 'Please sign in first.', 401);
        }

        $subscription = Subscription::where('user_id', $user->id)->first();

        if (!$subscription) {
            return $this->subscriptionResponse($request, false, 'Please choose a plan before resuming.', 404);
        }

        if ($subscription->status === 'active') {
            return $this->subscriptionResponse($request, false, 'Subscription is already active.');
        }

        $subscription->update([
            'status'      => 'active',
            'pause_until' => now()->toDateString(),
        ]);

        return $this->subscriptionResponse(
            $request, true,
            'Subscription resumed successfully.',
            200,
            ['subscription' => $subscription->fresh('plan')]
        );
    }

    /* =========================
       2. BOXES & CART
    ========================= */

    // Show all active boxes, optionally filtered by sport/type
    public function boxes(Request $request)
    {
        $boxes = Box::with('items.inventoryItem')
            ->where('is_active', true)
            ->when($request->filled('sport'), fn($q) => $q->where('box_type', $request->sport))
            ->get();

        return view('boxes', ['boxes' => $boxes, 'sport' => $request->sport]);
    }

    // Show a single box with available items for customisation
    public function customize($id)
    {
        $box            = Box::with('items.inventoryItem')->findOrFail($id);
        $availableItems = InventoryItem::whereNotIn('id', $box->items->pluck('inventory_item_id'))->get();

        return view('customize', compact('box', 'availableItems'));
    }

    // Add a box to the cart (from the boxes listing page)
    public function addToCart(Request $request, $boxId)
    {
        $box  = Box::findOrFail($boxId);
        $user = Auth::user()->load(['customer', 'subscription.plan']);

        $currentPlan = $user->subscription?->plan ?? $user->customer?->plan;

        if (!$currentPlan) {
            return redirect()->route('subscriptions')
                ->with('error', 'Please choose a plan before adding boxes to your cart.');
        }

        if ($user->subscription?->status === 'paused') {
            return redirect()->route('dashboard')
                ->with('error', 'Your subscription is paused. Resume it before adding boxes.');
        }

        $request->validate([
            'clothing_size'      => 'required|in:XS,S,M,L,XL,XXL',
            'diet_preference'    => 'required|in:standard,keto,vegan,Hiegh Protein',
            'delivery_frequency' => 'required|in:Monthly,Bi_Monthly,Quarterly',
        ]);

        // Enforce the plan's monthly box limit
        $monthlyLimit = $currentPlan->boxes_per_month ?? 0;
        $monthlyCount = BoxOrder::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereIn('status', ['pending', 'packed', 'shipped', 'out_for_delivery', 'delivered'])
            ->count();

        if ($monthlyLimit > 0 && $monthlyCount >= $monthlyLimit) {
            return redirect()->route('boxes')
                ->with('error', "Your current plan allows {$monthlyLimit} box(es) per month.");
        }

        // Prevent adding the same box twice
        $alreadyInCart = BoxOrder::where('user_id', $user->id)
            ->where('box_id', $box->id)
            ->where('status', 'pending')
            ->exists();

        if ($alreadyInCart) {
            return redirect()->route('cart')->with('error', 'Box already in cart.');
        }

        $this->saveCustomerPreferences($user->customer, $request);
        BoxOrder::create($this->buildOrderData($user, $box));

        return redirect()->route('cart')->with('success', 'Added successfully.');
    }

    // Save a customised box to the cart (from the customise page)
    public function saveCustomizedBox(Request $request, $id)
    {
        $box  = Box::findOrFail($id);
        $user = Auth::user()->load(['customer', 'subscription']);

        if (!$user->customer && Schema::hasColumn('box_orders', 'customer_id')) {
            return redirect()->route('subscriptions')
                ->with('error', 'Please choose a plan before saving a box to your cart.');
        }

        if ($user->subscription?->status === 'paused') {
            return redirect()->route('dashboard')
                ->with('error', 'Your subscription is paused. Resume it before saving boxes.');
        }

        $request->validate([
            'clothing_size'      => 'required|in:XS,S,M,L,XL,XXL',
            'diet_preference'    => 'required|in:standard,keto,vegan,Hiegh Protein',
            'delivery_frequency' => 'required|in:Monthly,Bi_Monthly,Quarterly',
        ]);

        $this->saveCustomerPreferences($user->customer, $request);
        BoxOrder::create($this->buildOrderData($user, $box));

        return redirect()->route('cart')->with('success', 'Customized box saved to cart.');
    }

    // Show the current user's cart (pending orders only)
    public function cart()
    {
        $orders = BoxOrder::with(['box.items.inventoryItem', 'user.customer'])
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        return view('cart', compact('orders'));
    }

    // Swap an active order's box for a different one
    public function swapBox(Request $request, $orderId)
    {
        $request->validate(['box_id' => 'required|exists:boxes,id']);

        $user = Auth::user()->load('subscription');

        if ($user->subscription?->status === 'paused') {
            return redirect()->route('dashboard')
                ->with('error', 'Your subscription is paused. Resume it before swapping boxes.');
        }

        $order  = BoxOrder::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'packed', 'shipped', 'out_for_delivery'])
            ->findOrFail($orderId);

        $newBox = Box::where('is_active', true)->findOrFail($request->box_id);

        // Make sure the user is actually choosing a different box
        if ((int) $order->box_id === (int) $newBox->id) {
            return redirect()->route('dashboard')
                ->with('error', 'Please choose a different box to swap.');
        }

        // Make sure the user doesn't already have the target box in an active order
        $alreadyHasBox = BoxOrder::where('user_id', $user->id)
            ->where('box_id', $newBox->id)
            ->whereIn('status', ['pending', 'packed', 'shipped', 'out_for_delivery'])
            ->where('id', '!=', $order->id)
            ->exists();

        if ($alreadyHasBox) {
            return redirect()->route('dashboard')
                ->with('error', 'You already have that box. Choose a different one.');
        }

        // Build update data and include optional columns if they exist
        $updateData = ['box_id' => $newBox->id, 'total_amount' => $newBox->base_price];

        if (Schema::hasColumn('box_orders', 'box_name')) {
            $updateData['box_name'] = $newBox->name;
        }
        if (Schema::hasColumn('box_orders', 'base_price')) {
            $updateData['base_price'] = $newBox->base_price;
        }

        $order->update($updateData);

        return redirect()->route('dashboard')
            ->with('success', "Box swapped to {$newBox->name} successfully.");
    }

    // Confirm shipping address and move all pending orders to 'packed'.
    // Also awards reward points for each confirmed order.
    public function confirmShipping(Request $request, AdminController $adminController)
    {
        $validated = $request->validate([
            'address'               => 'required|string|max:190',
            'city'                  => 'required|string|max:100',
            'country'               => 'required|string|max:100',
            'delivery_instructions' => 'nullable|string',
        ]);

        Customer::where('user_id', Auth::id())->update($validated);

        $orders = BoxOrder::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        foreach ($orders as $order) {
            $order->update(['status' => 'packed']);
            $adminController->awardRewardPointsForOrder($order);
        }

        return redirect()->route('dashboard')->with('success', 'Shipping confirmed.');
    }

    /* =========================
       3. REWARDS
    ========================= */

    // Show the customer's reward page with their points, tier, and available rewards
    public function reward()
    {
        $rewardAccount = RewardAccount::firstOrCreate(
            ['user_id' => Auth::id()],
            ['points' => 0, 'tier_name' => 'Bronze']
        );

        $themes  = Themes::with('items.inventoryItem')->latest()->get();
        $rewards = RewardItem::where('is_active', true)->orderBy('points')->get();

        return view('reward', [
            'rewardMode'    => 'customer',
            'rewardAccount' => $rewardAccount,
            'themes'        => $themes,
            'rewards'       => $rewards,
        ]);
    }

    // Redeem a specific reward item using the customer's points
    public function redeemReward($rewardId)
    {
        $reward        = RewardItem::where('is_active', true)->findOrFail($rewardId);
        $rewardAccount = RewardAccount::firstOrCreate(
            ['user_id' => Auth::id()],
            ['points' => 0, 'tier_name' => 'Bronze']
        );

        if ($rewardAccount->points < $reward->points) {
            return redirect()->route('reward')->with('error', 'Insufficient reward points.');
        }

        DB::transaction(function () use ($rewardAccount, $reward) {
            $rewardAccount->decrement('points', $reward->points);
            $rewardAccount->refresh();

            // Update tier based on remaining points
            $rewardAccount->tier_name = match(true) {
                $rewardAccount->points >= 500 => 'Gold',
                $rewardAccount->points >= 100 => 'Silver',
                default                       => 'Bronze',
            };
            $rewardAccount->save();

            $transactionData = ['user_id' => Auth::id(), 'points_used' => $reward->points];
            if (Schema::hasColumn('reward_transactions', 'type')) {
                $transactionData['type'] = 'redeemed';
            }

            RewardTransaction::create($transactionData);
        });

        return redirect()->route('reward')->with('success', "{$reward->name} redeemed successfully.");
    }

    /* =========================
       PRIVATE HELPERS
    ========================= */

    // Build the data array for creating a new BoxOrder
    private function buildOrderData(User $user, Box $box): array
    {
        $data = [
            'user_id'      => $user->id,
            'box_id'       => $box->id,
            'order_number' => 'BOX-' . strtoupper(Str::random(8)),
            'status'       => 'pending',
            'total_amount' => $box->base_price,
        ];

        if (Schema::hasColumn('box_orders', 'box_name')) {
            $data['box_name'] = $box->name;
        }

        if (Schema::hasColumn('box_orders', 'customer_id') && $user->customer) {
            $data['customer_id'] = $user->customer->id;
        }

        if (Schema::hasColumn('box_orders', 'base_price')) {
            $data['base_price'] = $box->base_price;
        }

        return $data;
    }

    // Save customer preferences (size, diet, frequency) if the columns exist
    private function saveCustomerPreferences(?Customer $customer, Request $request): void
    {
        if (!$customer) return;

        $updates = [];
        foreach (['clothing_size', 'diet_preference', 'delivery_frequency'] as $column) {
            if (Schema::hasColumn('customers', $column)) {
                $updates[$column] = $request->input($column);
            }
        }

        if ($updates) {
            $customer->update($updates);
        }
    }

    // Return the authenticated user — from session or bearer token
    private function getAuthUser(Request $request): ?User
    {
        if (Auth::check()) {
            return Auth::user();
        }

        $token = $request->bearerToken();
        return $token ? User::where('remember_token', $token)->first() : null;
    }

    // Return a redirect or JSON response depending on how the request was made
    private function subscriptionResponse(Request $request, bool $ok, string $message, int $status = 200, array $data = [])
    {
        if ($request->expectsJson() || $request->bearerToken()) {
            return response()->json(['ok' => $ok, 'message' => $message] + $data, $status);
        }

        return redirect()->route('dashboard')->with($ok ? 'success' : 'error', $message);
    }
}