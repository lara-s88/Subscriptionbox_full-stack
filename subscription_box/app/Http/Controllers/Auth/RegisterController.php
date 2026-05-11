<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    // Show the registration page
    public function index()
    {
        return view('auth.register');
    }

    // Handle registration for both customers and admins
    public function register(Request $request)
    {
        // Validate shared fields first
        $base = $request->validate([
            'account_type' => ['required', 'in:customer,admin'],
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'password'     => ['required', 'string', 'min:8'],
        ]);

        // Build email uniqueness rules depending on account type
        $emailRules = ['required', 'email', Rule::unique('users', 'email')];

        if ($base['account_type'] === 'admin') {
            if (!Schema::hasTable('admins')) {
                return back()->withErrors(['email' => 'Admin registration is not available.']);
            }
            $emailRules[] = Rule::unique('admins', 'email');
        } elseif (Schema::hasTable('admins')) {
            $emailRules[] = Rule::unique('admins', 'email');
        }

        $emailValidated = $request->validate(['email' => $emailRules]);

        $fullData = array_merge($base, $emailValidated);

        if ($base['account_type'] === 'admin') {
            return $this->createAdmin($fullData);
        }

        return $this->createCustomer($fullData);
    }

    /* =========================
       PRIVATE HELPERS
    ========================= */

    // Create a new admin account and redirect to login
    private function createAdmin(array $data)
    {
        Admin::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);

        return redirect()->route('login')
            ->with('status', 'Admin account created. Sign in as Admin with your credentials.');
    }

    // Create a new customer account and redirect to login
    private function createCustomer(array $data)
    {
        User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);

        return redirect()->route('login')
            ->with('status', 'Account created successfully. Sign in as Customer with your credentials.');
    }
}