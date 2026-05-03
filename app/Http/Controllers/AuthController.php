<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->intended(route('catalog'));
        return view('auth.form', ['mode' => 'login']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            /** @var User $user */
            $user = Auth::user();
            if ($user->role === 'seller') {
                return redirect()->route('seller.dashboard');
            }
            return redirect()->intended(route('catalog'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.form', ['mode' => 'register']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'role'      => 'required|in:buyer,seller',
            'shop_name' => 'required_if:role,seller|nullable|string|max:255',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        if ($request->role === 'seller') {
            Shop::create([
                'user_id'  => $user->id,
                'name'     => $request->shop_name ?? $request->name . "'s Shop",
                'city'     => 'Indonesia',
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'seller') {
            return redirect()->route('seller.dashboard');
        }
        return redirect()->route('catalog');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
