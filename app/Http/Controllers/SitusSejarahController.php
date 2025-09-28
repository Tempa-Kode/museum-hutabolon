<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\KategoriSitus;
use Illuminate\Support\Str;
use App\Models\SitusSejarah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SitusSejarahController extends Controller
{
    /**
     * Menampilkan seluruh daftar situs sejarah.
     */
    public function index()
    {
        $data = SitusSejarah::with('kategori', 'totalPencarian')->latest()->get();
        return view('situs-sejarah.index', compact('data'));
    }

    /**
     * Menampilkan form untuk membuat situs sejarah baru.
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('situs-sejarah.create', compact('kategori'));
    }

    /**
     * Menyimpan situs sejarah baru ke dalam database.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama' => 'required|string|max:50',
            'lokasi' => 'required|string|max:100',
            'deskripsi_konten' => 'required|string',
            'kategori_id' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $validasi['slug'] = Str::slug($validasi['nama']);
            $situsSejarah = SitusSejarah::create($validasi);
            foreach ($validasi['kategori_id'] as $kategoriId) {
                KategoriSitus::create([
                    'kategori_id' => $kategoriId,
                    'situs_sejarah_id' => $situsSejarah->id,
                ]);
            }
            DB::commit();
            return redirect()->route('situs-sejarah.index')->with('success', 'Situs sejarah berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

    /**
     * Menampilkan detail dari sebuah situs sejarah.
     */
    public function show($slug)
    {
        $data = SitusSejarah::with('kategori', 'komentar', 'gambarVideo')->where('slug', $slug)->firstOrFail();
        return view('situs-sejarah.show', compact('data'));
    }

    /**
     * Menampilkan form untuk mengedit situs sejarah yang sudah ada.
     */
    public function edit($slug)
    {
        $situsSejarah = SitusSejarah::with('kategori')->where('slug', $slug)->firstOrFail();
        $kategori = Kategori::all();
        return view('situs-sejarah.edit', compact('situsSejarah', 'kategori'));
    }

    /**
     * Memperbarui data situs sejarah yang sudah ada di dalam database.
     */
    public function update(Request $request, $slug)
    {
        $validasi = $request->validate([
            'nama' => 'required|string|max:50',
            'lokasi' => 'required|string|max:100',
            'deskripsi_konten' => 'required|string',
            'kategori_id' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $situsSejarah = SitusSejarah::where('slug', $slug)->firstOrFail();
            $validasi['slug'] = Str::slug($validasi['nama']);
            $situsSejarah->update($validasi);

            // Hapus kategori lama
            KategoriSitus::where('situs_sejarah_id', $situsSejarah->id)->delete();

            // Tambah kategori baru
            foreach ($validasi['kategori_id'] as $kategoriId) {
                KategoriSitus::create([
                    'kategori_id' => $kategoriId,
                    'situs_sejarah_id' => $situsSejarah->id,
                ]);
            }

            DB::commit();
            return redirect()->route('situs-sejarah.index')->with('success', 'Situs sejarah berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui data.'])->withInput();
        }
    }

    /**
     * Menghapus situs sejarah dari database.
     */
    public function destroy($slug)
    {
        $situsSejarah = SitusSejarah::where('slug', $slug)->firstOrFail();
        $situsSejarah->delete();
        return redirect()->route('situs-sejarah.index')->with('success', 'Situs sejarah berhasil dihapus.');
    }
}
