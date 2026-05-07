<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $base = $request->validate([
            'account_type' => ['required', 'in:customer,admin'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $emailRules = ['required', 'email'];
        if ($base['account_type'] === 'admin') {
            if (! Schema::hasTable('admins')) {
                return back()->withErrors(['email' => 'Admin registration is not available.']);
            }

            $emailRules[] = Rule::unique('admins', 'email');
            $emailRules[] = Rule::unique('users', 'email');
        } else {
            $emailRules[] = Rule::unique('users', 'email');
            if (Schema::hasTable('admins')) {
                $emailRules[] = Rule::unique('admins', 'email');
            }
        }

        $emailValidated = $request->validate([
            'email' => $emailRules,
        ]);

        if ($base['account_type'] === 'admin') {
            $admin = new Admin();
            $admin->first_name = $base['first_name'];
            $admin->last_name = $base['last_name'];
            $admin->email = $emailValidated['email'];
            $admin->password = Hash::make($base['password']);
            $admin->save();

            return redirect()
                ->route('login')
                ->with('status', 'Admin account created. Sign in as Admin with your credentials.');
        }

        $data = array_merge($base, $emailValidated);

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()
            ->route('login')
            ->with('status', 'Account created successfully. Sign in as Customer with your credentials.');
    }
}
