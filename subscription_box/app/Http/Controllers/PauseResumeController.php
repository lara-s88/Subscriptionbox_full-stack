<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class PauseResumeController extends Controller
{
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
}