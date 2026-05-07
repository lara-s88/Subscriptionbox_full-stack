<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Box;
use App\Models\BoxOrder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class BoxController extends Controller
{
    public function addToCart(Request $request, $boxId)
    {
        // 1. get box
        $box = Box::findOrFail($boxId);

        // 2. get logged in user
        $user = Auth::user();

        // 3. check if user is logged in
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'You must login first'
            ], 401);
        }

        // 4. check if box already in cart (pending order)
        $existingOrder = BoxOrder::where('user_id', $user->id)
            ->where('box_id', $box->id)
            ->where('status', 'pending')
            ->first();

        if ($existingOrder) {
            return response()->json([
                'status' => false,
                'message' => 'Box already in cart'
            ]);
        }

        // 5. create order
        $order = BoxOrder::create([
            'user_id' => $user->id,
            'box_id' => $box->id,
            'order_number' => 'BOX-' . strtoupper(Str::random(8)),
            'status' => 'pending',
            'total_amount' => $box->base_price,
        ]);

        // 6. return response
        return response()->json([
            'status' => true,
            'message' => 'Box added to cart successfully',
            'order' => $order
        ]);
    }
}