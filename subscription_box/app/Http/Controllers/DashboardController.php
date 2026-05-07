<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // app/Http/Controllers/DashboardController.php

public function index()
{
   // $user = auth()->user()->load('customer.plan');

    return view('dashboard', compact('user'));
}
}
