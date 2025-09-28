<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Menampilkan seluruh data admin
     */
    public function index()
    {
        $data = User::where('hak_akses', 'admin')->latest()->get();
        return view('pengguna.admin.index', compact('data'));
    }

    /**
     * Menampilkan form untuk membuat resource baru.
     */
    public function create()
    {
        return view('pengguna.admin.create');
    }

    /**
     * Menyimpan resource baru yang dibuat ke penyimpanan.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'notelp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $validasi['hak_akses'] = 'admin';
            $validasi['password'] = bcrypt($validasi['password']);
            User::create($validasi);
            DB::commit();
            return redirect()->route('admin.index')->with('success', 'Data admin berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data admin: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form untuk mengedit resource yang ditentukan.
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('pengguna.admin.edit', compact('data'));
    }

    /**
     * Memperbarui resource yang ditentukan di penyimpanan.
     */
    public function update(Request $request, $id)
    {
        $validasi = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email,' . $id,
            'notelp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $admin = User::findOrFail($id);
            if (!empty($validasi['password'])) {
                $validasi['password'] = bcrypt($validasi['password']);
            } else {
                unset($validasi['password']);
            }
            $admin->update($validasi);
            DB::commit();
            return redirect()->route('admin.index')->with('success', 'Data admin berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data admin: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus resource yang ditentukan dari penyimpanan.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $admin = User::findOrFail($id);
            $admin->delete();
            DB::commit();
            return redirect()->route('admin.index')->with('success', 'Data admin berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data admin: ' . $e->getMessage());
        }
    }
}
