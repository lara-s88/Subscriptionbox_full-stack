<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class LoginController extends Controller
{
    public function index()
    {
        if (Schema::hasTable('admins') && Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'account_type' => ['required', 'in:customer,admin'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($credentials['account_type'] === 'admin') {
            if (! Schema::hasTable('admins')) {
                return back()
                    ->withErrors(['email' => 'Admin sign-in is not available.'])
                    ->onlyInput('email', 'account_type');
            }

            $admin = Admin::where('email', $credentials['email'])->first();
            if (! $admin || ! Hash::check($credentials['password'], $admin->password)) {
                return back()
                    ->withErrors(['email' => 'Invalid admin email or password.'])
                    ->onlyInput('email', 'account_type');
            }

            Auth::guard('web')->logout();
            Auth::guard('admin')->login($admin, false);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withErrors(['email' => 'Invalid customer email or password.'])
                ->onlyInput('email', 'account_type');
        }

        Auth::guard('admin')->logout();
        Auth::guard('web')->login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
