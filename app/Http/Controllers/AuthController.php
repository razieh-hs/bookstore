<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4',
        ], [
            'email.required' => 'ایمیل را وارد کنید',
            'email.email' => 'ایمیل نامعتبر است',
            'password.required' => 'رمز عبور را وارد کنید',
            'password.min' => 'رمز عبور حداقل ۴ کاراکتر است',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'خوش آمدی مدیر عزیز! 👑');
            }

            return redirect()->intended(route('profile.index'))
                ->with('success', 'خوش آمدی! به کتابستان وارد شدی 📚');
        }

        return back()->withErrors([
            'email' => 'ایمیل یا رمز عبور اشتباه است.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);

        Auth::login($user);

        return redirect()->route('profile.index')
            ->with('success', 'حسابت ساخته شد! خوش آمدی به کتابستان 🎉');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'با موفقیت خارج شدی. به امید دیدار! 👋');
    }
}