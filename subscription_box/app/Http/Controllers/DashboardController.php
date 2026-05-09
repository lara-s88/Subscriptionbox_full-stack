<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\BoxOrder;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user()->load(['customer.plan', 'subscription.plan']);

        $orders = BoxOrder::with('box.items.inventoryItem')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $upcomingOrder = $orders
            ->whereIn('status', ['pending', 'packed', 'shipped', 'out_for_delivery'])
            ->first();
        $upcomingOrders = $orders
            ->whereIn('status', ['pending', 'packed', 'shipped', 'out_for_delivery']);
        $ownedBoxIds = $upcomingOrders->pluck('box_id')->unique()->values();
        $swapBoxes = Box::with('items.inventoryItem')
            ->where('is_active', true)
            ->whereNotIn('id', $ownedBoxIds)
            ->orderBy('name')
            ->get();

        return view('dashboard', [
            'dashboardMode' => 'customer',
            'user' => $user,
            'customer' => $user->customer,
            'subscription' => $user->subscription,
            'currentPlan' => $user->subscription?->plan ?? $user->customer?->plan,
            'memberSince' => $user->created_at,
            'orders' => $orders,
            'upcomingOrder' => $upcomingOrder,
            'upcomingOrders' => $upcomingOrders,
            'swapBoxes' => $swapBoxes,
        ]);
    }
}
