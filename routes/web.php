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
