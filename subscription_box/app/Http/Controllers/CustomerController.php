<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Customer;
use App\Models\User;
use App\Models\Box;
use App\Models\BoxOrder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    //Multi Tier & Upgrade and downgrade
    public function selectPlan(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $request->validate([
        'plan_id' => 'required|exists:plans,id',
    ]);

    $plan = Plan::find($request->plan_id);

    Customer::updateOrCreate(
        ['user_id' => Auth::id()],
        ['plan_id' => $plan->id]
    );

    return redirect()->route('dashboard');
}
   //Pause/Resume Subscription:
   public function pauseSubscription(Request $request)
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

    if ($user->status === 'paused') {
        return response()->json([
            'ok' => false,
            'message' => 'Subscription already paused'
        ]);
    }

    $user->status = 'paused';
    $user->paused_at = now();
    $user->save();

    return response()->json([
        'ok' => true,
        'message' => 'Subscription paused successfully',
        'user' => $user
    ]);
}

  public function resumeSubscription(Request $request)
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

    if ($user->status === 'active') {
        return response()->json([
            'ok' => false,
            'message' => 'Subscription already active'
        ]);
    }

    $user->status = 'active';
    $user->paused_at = null;
    $user->save();

    return response()->json([
        'ok' => true,
        'message' => 'Subscription resumed successfully',
        'user' => $user
    ]);
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
        $user = Auth::user();

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
        BoxOrder::create([
            'user_id' => $user->id,
            'box_id' => $box->id,
            'order_number' => 'BOX-' . strtoupper(Str::random(8)),
            'status' => 'pending',
            'total_amount' => $box->base_price,
        ]);

        return redirect()->route('cart')
            ->with('success', 'Added successfully');
    }


    public function cart()
    {
        // check login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // get cart orders
        $orders = BoxOrder::with('box')
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
     public function customize($id)
{
    $box = Box::with('items')->findOrFail($id);

    return view('customize', compact('box'));
}
//
}
