<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    
public function register(Request $request)
{
    $user = new User();
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->save();
    return response()->json([
        'ok' => true,
        'message' => 'User created',
        'users' => $user
    ]);
}
}