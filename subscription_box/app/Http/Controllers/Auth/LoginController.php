<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
{
    return view('auth.login');
}
   
public function login(Request $request)
{
    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'ok' => false,
            'message' => 'Invalid email or password'
        ]);
    }

    Auth::login($user);

    return response()->json([
        'ok' => true,
        'message' => 'Login success'
    ]);
}

}