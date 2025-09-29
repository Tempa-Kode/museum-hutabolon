<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('login');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [App\Http\Controllers\AuthController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::prefix('kategori')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/tambah', [App\Http\Controllers\KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/simpan', [App\Http\Controllers\KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/{id}/edit', [App\Http\Controllers\KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/{id}/update', [App\Http\Controllers\KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/{id}/hapus', [App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori.destroy');
});

// Route resource untuk admin
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/tambah', [App\Http\Controllers\AdminController::class, 'create'])->name('admin.create');
    Route::post('/simpan', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
    Route::get('/{id}/edit', [App\Http\Controllers\AdminController::class, 'edit'])->name('admin.edit');
    Route::put('/{id}/update', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
    Route::delete('/{id}/hapus', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.destroy');
});

// Route resource untuk pengelola konten
Route::prefix('pengelola-konten')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\PengelolaKontenController::class, 'index'])->name('pengelola-konten.index');
    Route::get('/tambah', [App\Http\Controllers\PengelolaKontenController::class, 'create'])->name('pengelola-konten.create');
    Route::post('/simpan', [App\Http\Controllers\PengelolaKontenController::class, 'store'])->name('pengelola-konten.store');
    Route::get('/{id}/edit', [App\Http\Controllers\PengelolaKontenController::class, 'edit'])->name('pengelola-konten.edit');
    Route::put('/{id}/update', [App\Http\Controllers\PengelolaKontenController::class, 'update'])->name('pengelola-konten.update');
    Route::delete('/{id}/hapus', [App\Http\Controllers\PengelolaKontenController::class, 'destroy'])->name('pengelola-konten.destroy');
});

// Route resource untuk situs sejarah
Route::prefix('situs-sejarah')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\SitusSejarahController::class, 'index'])->name('situs-sejarah.index');
    Route::get('/tambah', [App\Http\Controllers\SitusSejarahController::class, 'create'])->name('situs-sejarah.create');
    Route::post('/simpan', [App\Http\Controllers\SitusSejarahController::class, 'store'])->name('situs-sejarah.store');
    Route::get('/{slug}', [App\Http\Controllers\SitusSejarahController::class, 'show'])->name('situs-sejarah.show');
    Route::get('/{slug}/edit', [App\Http\Controllers\SitusSejarahController::class, 'edit'])->name('situs-sejarah.edit');
    Route::get('/{slug}/tambah-vidgam', [App\Http\Controllers\SitusSejarahController::class, 'createVidGam'])->name('situs-sejarah.tambah-vidgam');
    Route::post('/{slug}/simpan-vidgam', [App\Http\Controllers\SitusSejarahController::class, 'storeVidGam'])->name('situs-sejarah.simpan-vidgam');
    Route::put('/{slug}/update', [App\Http\Controllers\SitusSejarahController::class, 'update'])->name('situs-sejarah.update');
    Route::delete('/{slug}/hapus', [App\Http\Controllers\SitusSejarahController::class, 'destroy'])->name('situs-sejarah.destroy');
});
