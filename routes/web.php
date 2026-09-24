<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ── Halaman Publik ──
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ── Route yang Membutuhkan Login ──
Route::middleware('auth')->group(function () {

    // Dashboard (dari Breeze)
    Route::get('/dashboard', function () {
        return redirect()->route('products.index');
    })->name('dashboard');

    // Produk: hanya admin dan seller yang boleh mengelola (create, store, edit, update, destroy).
    // Harus didaftarkan SEBELUM route show agar /products/create tidak dianggap {product}.
    Route::middleware('role:admin,seller')->group(function () {
        Route::resource('products', ProductController::class)->except(['index', 'show']);
    });

    // Produk: semua user yang login boleh melihat
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Profile (dari Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ── Admin Only ──
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Auth routes (dari Breeze)
require __DIR__.'/auth.php';
