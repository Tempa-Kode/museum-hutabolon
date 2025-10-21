<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\SitusSejarah;
use App\Models\TotalPencarian;
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
                case 'pengelola-konten':
                    return redirect()->route('dashboard');
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
        $situsSejarah = SitusSejarah::count('id');
        $kategori = Kategori::count('id');

        // Ambil top 10 pencarian situs sejarah
        $topPencarian = TotalPencarian::with('situsSejarah')
            ->orderBy('jlh_pencarian', 'desc')
            ->limit(10)
            ->get();

        // Siapkan data untuk chart
        $topPencarianLabels = $topPencarian->map(function($item) {
            return $item->situsSejarah->nama ?? 'N/A';
        });

        $topPencarianCounts = $topPencarian->pluck('jlh_pencarian');

        return view('dashboard', compact('situsSejarah', 'kategori', 'topPencarianLabels', 'topPencarianCounts'));
    }
}
