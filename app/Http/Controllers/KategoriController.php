<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * menampilkan semua data kategori
     */
    public function index()
    {
        $data = Kategori::latest()->get();
        return view('kategori.index', compact('data'));
    }

    /**
     * menampilkan form untuk membuat kategori baru
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Menyimpan kategori baru
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori',
            'deskripsi' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $validasi['slug'] = Str::slug($validasi['nama_kategori']);
            Kategori::create($validasi);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan kategori: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * menampilkan form untuk mengedit kategori
     */
    public function edit($id)
    {
        try {
            $data = Kategori::find($id);
            return view('kategori.edit', compact('data'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Memperbarui kategori yang ada
     */
    public function update(Request $request, $id)
    {
        $validasi = $request->validate([
            'nama_kategori' => 'required|unique:kategori,nama_kategori,' . $id,
            'deskripsi' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $validasi['slug'] = Str::slug($validasi['nama_kategori']);
            Kategori::where('id', $id)->update($validasi);
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat memperbarui kategori: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Menghapus data kategori berdasarkan id
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $data = Kategori::find($id);
            $data->delete();
            DB::commit();
            return redirect()->route('kategori.index')->with('success', "Kategori {$data->nama_kategori} berhasil dihapus");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menghapus kategori: ' . $e->getMessage()]);
        }
    }
}
