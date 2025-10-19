<?php

namespace App\Http\Controllers;

use App\Models\KomentarSitusSejarah;
use App\Models\SitusSejarah;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function tambahKomentar(Request $request, $situsSejarahId)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'komentar' => 'required|string',
        ]);

        $situsSejarah = SitusSejarah::findOrFail($situsSejarahId);

        $situsSejarah->komentar()->create([
            'nama' => $request->nama,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function index()
    {
        $data = KomentarSitusSejarah::with('situsSejarah')->latest()->get();
        return view('komentar.index', compact('data'));
    }

    public function destroy($id)
    {
        $komentar = KomentarSitusSejarah::findOrFail($id);
        $komentar->delete();

        return redirect()->route('komentar.index')->with('success', 'Komentar berhasil dihapus.');
    }
}
