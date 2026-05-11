<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\BoxOrder;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Load the customer dashboard with their subscription, orders, and available swap boxes
    public function index()
    {
        $user = Auth::user()->load(['customer.plan', 'subscription.plan']);

        // Fetch all orders for this user, newest first
        $orders = BoxOrder::with('box.items.inventoryItem')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Active orders are anything not yet delivered or returned
        $activeStatuses   = ['pending', 'packed', 'shipped', 'out_for_delivery'];
        $upcomingOrders   = $orders->whereIn('status', $activeStatuses);
        $upcomingOrder    = $upcomingOrders->first(); // the most recent active order

        // Boxes the user currently has in active orders — exclude these from swap options
        $ownedBoxIds = $upcomingOrders->pluck('box_id')->unique()->values();
        $swapBoxes   = Box::with('items.inventoryItem')
            ->where('is_active', true)
            ->whereNotIn('id', $ownedBoxIds)
            ->orderBy('name')
            ->get();

        return view('dashboard', [
            'dashboardMode' => 'customer',
            'user'          => $user,
            'customer'      => $user->customer,
            'subscription'  => $user->subscription,
            'currentPlan'   => $user->subscription?->plan ?? $user->customer?->plan,
            'memberSince'   => $user->created_at,
            'orders'        => $orders,
            'upcomingOrder' => $upcomingOrder,
            'upcomingOrders'=> $upcomingOrders,
            'swapBoxes'     => $swapBoxes,
        ]);
    }
}