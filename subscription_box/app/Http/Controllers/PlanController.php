<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
  

class PlanController extends Controller

   
{public function selectPlan(Request $request)
{
    
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    $request->validate([
        'plan_name' => 'required|string',
    ]);

    
    $plan = Plan::where('name', $request->plan_name)->first();

    if (!$plan) {
        return back()->withErrors(['plan_name' => 'Plan not found']);
    }

    
    Customer::updateOrCreate(
        ['user_id' => $user->id],
        ['plan_id' => $plan->id]
    );

    

    return redirect()->route('dashboard');
}
}


