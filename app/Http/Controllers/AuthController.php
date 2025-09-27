<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $role = Auth::user()->hak_akses;
            switch ($role) {
                case 'admin':
                    return redirect()->route('dashboard');
                // case 'tamu':
                //     return redirect()->route('user/dashboard');
                // case 'pengelola-konten':
                //     return redirect()->route('user/dashboard');
                default:
                    Auth::logout();
                    return back()->with(
                        'error',
                        'anda tidak memiliki hak akses yang valid.'
                    );
            }
        }

        return back()->with([
            'error' => 'Email atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function index()
    {
        return view('dashboard');
    }
}
