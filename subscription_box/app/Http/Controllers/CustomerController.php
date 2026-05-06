<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerProfile;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
   public function Register (Request $request)
   {
    $user = new User();
    $user->firstname = $request->firstname;
    $user->lastname = $request->lastname;
    $user->email = $request->email;
    $user->role = $request->role;
    $user->password = Hash::make($request->password);


   // $customer = new CustomerProfile();
    //$customer->user_id = $request->firstname;
    //$customer->lastname = $request->lastname;
    //$customer->email = $request->email;
    //$customer->role = $request->role;
    //$customer->password = Hash::make($request->password);
     


   }
}
