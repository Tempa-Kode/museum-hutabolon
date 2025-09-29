<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Str;
use App\Models\SitusSejarah;
use Illuminate\Http\Request;
use App\Models\KategoriSitus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    /**
     * Menampilkan form untuk menambahkan video atau gambar ke situs sejarah.
     */
    public function createVidGam($slug)
    {
        $data = SitusSejarah::where('slug', $slug)->firstOrFail();
        return view('situs-sejarah.tambah-vidgam', compact('data'));
    }

    /**
     * Menyimpan video atau gambar ke dalam database.
     */
    public function storeVidGam(Request $request, $slug)
    {
        $validasi = $request->validate([
            'jenis' => 'required|in:vidio,gambar',
            'gambar' => 'required_if:jenis,gambar|image|max:5120',
            'video_url' => 'required_if:jenis,vidio',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $situsSejarah = SitusSejarah::where('slug', $slug)->firstOrFail();

            if ($validasi['jenis'] === 'gambar') {
                // Buat folder uploads jika belum ada
                $uploadPath = public_path('uploads');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                // Generate nama file unik
                $file = $request->file('gambar');
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Pindahkan file ke public/uploads
                $file->move($uploadPath, $fileName);

                // Simpan path relatif ke database
                $gambarPath = 'uploads/' . $fileName;

                $situsSejarah->gambarVideo()->create([
                    'jenis' => 'gambar',
                    'link' => $gambarPath,
                ]);
            } else {
                $situsSejarah->gambarVideo()->create([
                    'jenis' => 'vidio',
                    'link' => $validasi['video_url'],
                ]);
            }

            DB::commit();
            return redirect()->route('situs-sejarah.show', $slug)->with('success', 'Media berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing media: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan media: ' . $e->getMessage()])->withInput();
        }
    }
}
