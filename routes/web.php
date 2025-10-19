<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'beranda'])->name('home');
Route::get('/gallery', [App\Http\Controllers\HomeController::class, 'gallery'])->name('gallery');
Route::get('/events', [App\Http\Controllers\HomeController::class, 'event'])->name('events');
Route::get('/gallery/{situsSejarah:slug}', [App\Http\Controllers\HomeController::class, 'detailGallery'])->name('gallery.detail');
Route::post('/gallery/{situsSejarahId}/komentar', [App\Http\Controllers\KomentarController::class, 'tambahKomentar'])->name('gallery.tambah-komentar');

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
    Route::delete('/{slug}/hapus-media/{mediaId}', [App\Http\Controllers\SitusSejarahController::class, 'deleteMedia'])->name('situs-sejarah.hapus-media');
    Route::put('/{slug}/update', [App\Http\Controllers\SitusSejarahController::class, 'update'])->name('situs-sejarah.update');
    Route::delete('/{slug}/hapus', [App\Http\Controllers\SitusSejarahController::class, 'destroy'])->name('situs-sejarah.destroy');
});

// Route resource untuk event
Route::prefix('event')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\EventController::class, 'index'])->name('event.index');
    Route::get('/tambah', [App\Http\Controllers\EventController::class, 'create'])->name('event.create');
    Route::post('/simpan', [App\Http\Controllers\EventController::class, 'store'])->name('event.store');
    Route::get('/{id}', [App\Http\Controllers\EventController::class, 'show'])->name('event.show');
    Route::get('/{event:id}/edit', [App\Http\Controllers\EventController::class, 'edit'])->name('event.edit');
    Route::put('/{event:id}/update', [App\Http\Controllers\EventController::class, 'update'])->name('event.update');
    Route::delete('/{event:id}/hapus', [App\Http\Controllers\EventController::class, 'destroy'])->name('event.destroy');
});
