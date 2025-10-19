<?php

namespace App\Http\Controllers;

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
}
