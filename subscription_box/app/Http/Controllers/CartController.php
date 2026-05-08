<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\BoxOrder;
 

class CartController extends Controller
{
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

        // 3. التحقق من البيانات المرسلة من الـ Preferences
        $validated = $request->validate([
            'clothing_size'   => 'required|string',
            'diet_preference' => 'required|string',
            'frequency'       => 'required|string',
        ]);

        // 4. حفظ البيانات في الداتابيز وربطها بالمستخدم
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
}