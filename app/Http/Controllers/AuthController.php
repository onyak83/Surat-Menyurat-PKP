<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function viewLogin()
    {
        return view('login.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

        if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ], $request->remember)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()
        ->withErrors([
            'email' => 'Email atau password salah.'
        ])
        ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Flush semua session untuk keamanan ekstra
        $request->session()->invalidate();
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Anda telah logout.');
    }
}
