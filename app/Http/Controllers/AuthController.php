<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected function authenticated(Request $request, $user)
    {
        // Deactivate expired users on login
        User::deactivateExpiredUsers();

        // Optional: redirect based on role, etc.
        return redirect()->intended('dashboard');
    }
    public function showRegisterForm()
    {
        $company = auth()->user()->company;
        return view('auth.register', compact('company'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'company_id' => 'nullable|exists:companies,id',
            'status' => 'required|in:active,inactive',
            'role' => 'required|in:admin,manager,employee',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => $request->company_id,
            'status' => $request->status,
            'role' => $request->role,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Redirect based on role
            if ($user->role === 'employee') {
                return redirect('/sales/create');
            } else {
                return redirect('/dashboard');
            }
        }

        return view('auth.login'); // or your login view
    }

    public function login(Request $request)
{
    // Deactivate expired users before attempting login
    User::deactivateExpiredUsers();

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Only allow login if user is active
    $credentials['status'] = 'active';

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role === 'employee') {
            return redirect()->intended('/sales/create');
        }

        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials or inactive account.',
    ])->onlyInput('email');
}



    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
