<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.user-login');
    }

    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->role === 'admin') {
                Auth::logout();
                return redirect()->route('admin.login')->with('error', 'Silakan gunakan halaman login admin.');
            } else {
                return redirect()->route('user.dashboard')->with('success', 'Selamat datang kembali!');
            }
        }

        return back()->withErrors(['email' => 'Email atau password tidak valid.']);
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'captcha' => 'required',
        ]);

        // Verify captcha
        // $captchaDisplay = $request->session()->get('captcha_code');
        // if (strtoupper($request->captcha) !== $captchaDisplay) {
        //     return back()->withErrors(['captcha' => 'Kode verifikasi tidak sesuai.']);
        // }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login admin berhasil.');
            } else {
                Auth::logout();
                return redirect()->route('user.login')->with('error', 'Silakan gunakan halaman login user.');
            }
        }

        return back()->withErrors(['email' => 'Kredensial admin tidak valid.']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('user.login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.login')->with('success', 'Logout berhasil.');
    }
}
