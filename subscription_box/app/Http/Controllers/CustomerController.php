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
    //Multi Tier & Upgrade and downgrade
    public function selectPlan(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $request->validate([
        'plan_id' => 'required_without:plan_name|exists:plans,id',
        'plan_name' => 'required_without:plan_id|exists:plans,name',
    ]);

    $plan = $request->filled('plan_id')
        ? Plan::find($request->plan_id)
        : Plan::where('name', $request->plan_name)->first();

    $customerValues = [];
    if (Schema::hasColumn('customers', 'plan_id')) {
        $customerValues['plan_id'] = $plan->id;
    }

    Customer::updateOrCreate(['user_id' => Auth::id()], $customerValues);

    if (Schema::hasTable('subscriptions')) {
        Subscription::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'plan_id' => $plan->id,
                'status' => 'active',
                'last_billing_date' => now()->toDateString(),
                'next_billing_date' => now()->addMonth()->toDateString(),
                'pause_until' => now()->toDateString(),
                'started_at' => now()->toDateString(),
                'renewal_day' => now()->day,
            ]
        );
    }

    return redirect()->route('dashboard');
}
   //Pause/Resume Subscription:
   public function pauseSubscription(Request $request)
{
    $user = $this->userFromRequest($request);

    if (! $user) {
        return $this->subscriptionResponse($request, false, 'Please sign in first.', 401);
    }

    $validated = $request->validate([
        'months' => 'nullable|integer|min:1|max:3',
    ]);

    $subscription = Subscription::where('user_id', $user->id)->first();

    if (! $subscription) {
        return $this->subscriptionResponse($request, false, 'Please choose a plan before pausing your subscription.', 404);
    }

    if ($subscription->status === 'paused') {
        return $this->subscriptionResponse($request, false, 'Subscription is already paused.');
    }

    $months = (int) ($validated['months'] ?? 1);
    $pauseUntil = now()->addMonths($months)->toDateString();

    $subscription->update([
        'status' => 'paused',
        'pause_until' => $pauseUntil,
    ]);

    return $this->subscriptionResponse(
        $request,
        true,
        'Subscription paused until ' . $subscription->fresh()->pause_until->format('M d, Y') . '.',
        200,
        ['subscription' => $subscription->fresh('plan')]
    );
}

  public function resumeSubscription(Request $request)
{
    $user = $this->userFromRequest($request);

    if (! $user) {
        return $this->subscriptionResponse($request, false, 'Please sign in first.', 401);
    }

    $subscription = Subscription::where('user_id', $user->id)->first();

    if (! $subscription) {
        return $this->subscriptionResponse($request, false, 'Please choose a plan before resuming your subscription.', 404);
    }

    if ($subscription->status === 'active') {
        return $this->subscriptionResponse($request, false, 'Subscription is already active.');
    }

    $subscription->update([
        'status' => 'active',
        'pause_until' => now()->toDateString(),
    ]);

    return $this->subscriptionResponse(
        $request,
        true,
        'Subscription resumed successfully.',
        200,
        ['subscription' => $subscription->fresh('plan')]
    );
}
  //add to cart in Box Page
  public function addToCart(Request $request, $boxId)
    {
        // check login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // get box
        $box = Box::findOrFail($boxId);

        // logged in user
        $user = Auth::user()->load(['customer', 'subscription.plan']);

        $currentPlan = $user->subscription?->plan ?? $user->customer?->plan;

        if (! $currentPlan) {
            return redirect()->route('subscriptions')
                ->with('error', 'Please choose a plan before adding boxes to your cart.');
        }

        if ($user->subscription?->status === 'paused') {
            return redirect()->route('dashboard')
                ->with('error', 'Your subscription is paused. Resume it before adding boxes.');
        }

        $request->validate([
            'clothing_size' => 'required|in:XS,S,M,L,XL,XXL',
            'diet_preference' => 'required|in:standard,keto,vegan,Hiegh Protein',
            'delivery_frequency' => 'required|in:Monthly,Bi_Monthly,Quarterly',
        ]);

        $monthlyLimit = $currentPlan->boxes_per_month ?? 0;
        $monthlyOrdersCount = BoxOrder::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereIn('status', ['pending', 'packed', 'shipped', 'out_for_delivery', 'delivered'])
            ->count();

        if ($monthlyLimit > 0 && $monthlyOrdersCount >= $monthlyLimit) {
            return redirect()->route('boxes')
                ->with('error', 'Your current plan allows ' . $monthlyLimit . ' box(es) per month.');
        }

        $this->saveCustomerPreferences($user->customer, $request);

        // check if already exists
        $existingOrder = BoxOrder::where('user_id', $user->id)
            ->where('box_id', $box->id)
            ->where('status', 'pending')
            ->first();

        if ($existingOrder) {
            return redirect()->route('cart')
                ->with('error', 'Box already in cart');
        }

        // create order
        BoxOrder::create($this->boxOrderData($user, $box));

        return redirect()->route('cart')
            ->with('success', 'Added successfully');
    }

    private function boxOrderData(User $user, Box $box): array
    {
        $data = [
            'user_id' => $user->id,
            'box_id' => $box->id,
            'order_number' => 'BOX-' . strtoupper(Str::random(8)),
            'status' => 'pending',
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


    public function cart()
    {
        // check login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // get cart orders
        $orders = BoxOrder::with(['box.items.inventoryItem', 'user.customer'])
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        return view('cart', compact('orders'));
    }
    // storePrefrences 
    public function store(Request $request)
    {
        $token = $request->bearerToken(); 

        if (!$token) {
        return response()->json([
            'ok' => false,
            'message' => 'Token not provided'
        ], 401);
       }

       $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid token'
            ], 401);
        }

     
        $validated = $request->validate([
            'clothing_size'   => 'required|string',
            'diet_preference' => 'required|string',
            'frequency'       => 'required|string',
        ]);

      
        $order = BoxOrder::create([
            'user_id'            => $user->id,
            'clothing_size'      => $validated['clothing_size'],
            'diet_preference'    => $validated['diet_preference'],
            'delivery_frequency' => $validated['frequency'],
        ]);

         return response()->json([
            'ok' => true,
            'message' => 'Box added to cart',
            'cart' => $order
        ]);
    }
    //save to cart button in customize page
    public function getCart(Request $request)
{

    $token = $request->bearerToken();

    $user = user::where('remember_token', $token)->first();

    if (!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'Invalid token'
            ], 401);
        }


    $cartItems = BoxOrder::where('user_id', $user->id)->get();

    return response()->json([

        'ok' => true,

        'items' => $cartItems

    ]);
}
     //customize Box:
     public function boxes(Request $request)
{
    $query = Box::with('items.inventoryItem')->where('is_active', true);

    if ($request->filled('sport')) {
        $query->where('box_type', $request->sport);
    }

    return view('boxes', [
        'boxes' => $query->get(),
        'sport' => $request->sport,
    ]);
}

     public function customize($id)
{
    $box = Box::with('items.inventoryItem')->findOrFail($id);
    $availableItems = InventoryItem::whereNotIn('id', $box->items->pluck('inventory_item_id'))->get();

    return view('customize', compact('box', 'availableItems'));
}

public function saveCustomizedBox(Request $request, $id)
{
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $box = Box::findOrFail($id);

    $request->validate([
        'clothing_size' => 'required|in:XS,S,M,L,XL,XXL',
        'diet_preference' => 'required|in:standard,keto,vegan,Hiegh Protein',
        'delivery_frequency' => 'required|in:Monthly,Bi_Monthly,Quarterly',
    ]);

    $this->saveCustomerPreferences(Auth::user()->customer, $request);

    $user = Auth::user()->load(['customer', 'subscription']);

    if (Schema::hasColumn('box_orders', 'customer_id') && ! $user->customer) {
        return redirect()->route('subscriptions')
            ->with('error', 'Please choose a plan before saving a box to your cart.');
    }

    if ($user->subscription?->status === 'paused') {
        return redirect()->route('dashboard')
            ->with('error', 'Your subscription is paused. Resume it before saving boxes.');
    }

    BoxOrder::create($this->boxOrderData($user, $box));

    return redirect()->route('cart')->with('success', 'Customized box saved to cart.');
}

public function swapBox(Request $request, $orderId)
{
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $request->validate([
        'box_id' => 'required|exists:boxes,id',
    ]);

    $user = Auth::user()->load('subscription');

    if ($user->subscription?->status === 'paused') {
        return redirect()->route('dashboard')
            ->with('error', 'Your subscription is paused. Resume it before swapping boxes.');
    }

    $order = BoxOrder::where('user_id', $user->id)
        ->whereIn('status', ['pending', 'packed', 'shipped', 'out_for_delivery'])
        ->findOrFail($orderId);

    $newBox = Box::where('is_active', true)->findOrFail($request->box_id);

    if ((int) $order->box_id === (int) $newBox->id) {
        return redirect()->route('dashboard')
            ->with('error', 'Please choose a different box to swap.');
    }

    $alreadyHasBox = BoxOrder::where('user_id', $user->id)
        ->where('box_id', $newBox->id)
        ->whereIn('status', ['pending', 'packed', 'shipped', 'out_for_delivery'])
        ->where('id', '!=', $order->id)
        ->exists();

    if ($alreadyHasBox) {
        return redirect()->route('dashboard')
            ->with('error', 'You already have that box. Choose a box you do not have.');
    }

    $updateData = [
        'box_id' => $newBox->id,
        'total_amount' => $newBox->base_price,
    ];

    if (Schema::hasColumn('box_orders', 'box_name')) {
        $updateData['box_name'] = $newBox->name;
    }

    if (Schema::hasColumn('box_orders', 'base_price')) {
        $updateData['base_price'] = $newBox->base_price;
    }

    $order->update($updateData);

    return redirect()->route('dashboard')
        ->with('success', 'Box swapped to ' . $newBox->name . ' successfully.');
}

public function confirmShipping(Request $request, AdminController $adminController)
{
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $validated = $request->validate([
        'address' => 'required|string|max:190',
        'city' => 'required|string|max:100',
        'country' => 'required|string|max:100',
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

public function reward()
{
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $rewardAccount = RewardAccount::firstOrCreate(
        ['user_id' => Auth::id()],
        ['points' => 0, 'tier_name' => 'Bronze']
    );

    $themes = Themes::with('items.inventoryItem')->latest()->get();
    $rewards = Schema::hasTable('reward_items')
        ? RewardItem::where('is_active', true)->orderBy('points')->get()
        : collect();

    return view('reward', [
        'rewardMode' => 'customer',
        'rewardAccount' => $rewardAccount,
        'themes' => $themes,
        'rewards' => $rewards,
    ]);
}

public function redeemReward($rewardId)
{
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $reward = RewardItem::where('is_active', true)->findOrFail($rewardId);

    $rewardAccount = RewardAccount::firstOrCreate(
        ['user_id' => Auth::id()],
        ['points' => 0, 'tier_name' => 'Bronze']
    );

    if ($rewardAccount->points < $reward->points) {
        return redirect()->route('reward')
            ->with('error', 'Insufficient reward points.');
    }

    DB::transaction(function () use ($rewardAccount, $reward) {
        $rewardAccount->decrement('points', $reward->points);
        $rewardAccount->refresh();

        if ($rewardAccount->points >= 500) {
            $rewardAccount->tier_name = 'Gold';
        } elseif ($rewardAccount->points >= 100) {
            $rewardAccount->tier_name = 'Silver';
        } else {
            $rewardAccount->tier_name = 'Bronze';
        }

        $rewardAccount->save();

        $transactionData = [
            'user_id' => Auth::id(),
            'points_used' => $reward->points,
        ];

        if (Schema::hasColumn('reward_transactions', 'type')) {
            $transactionData['type'] = 'redeemed';
        }

        RewardTransaction::create($transactionData);
    });

    return redirect()->route('reward')
        ->with('success', $reward->name . ' redeemed successfully.');
}

private function saveCustomerPreferences(?Customer $customer, Request $request): void
{
    if (! $customer) {
        return;
    }

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

private function userFromRequest(Request $request): ?User
{
    if (Auth::check()) {
        return Auth::user();
    }

    $token = $request->bearerToken();

    return $token ? User::where('remember_token', $token)->first() : null;
}

private function subscriptionResponse(Request $request, bool $ok, string $message, int $status = 200, array $data = [])
{
    if ($request->expectsJson() || $request->bearerToken()) {
        return response()->json([
            'ok' => $ok,
            'message' => $message,
        ] + $data, $status);
    }

    return redirect()->route('dashboard')
        ->with($ok ? 'success' : 'error', $message);
}
//
}
