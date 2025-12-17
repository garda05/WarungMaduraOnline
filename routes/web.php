<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/**
 * Profile (semua user yang login)
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * TEST ROUTES (boleh hapus nanti)
 */
Route::middleware(['auth', 'role:penjual'])->get('/seller-test', function () {
    return 'OK PENJUAL';
})->name('seller.test');

Route::middleware(['auth', 'role:pelanggan'])->get('/buyer-test', function () {
    return 'OK PELANGGAN';
})->name('buyer.test');

/**
 * PENJUAL routes (CRUD produk, dll)
 */
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::resource('products', ProductController::class);
});

/**
 * PELANGGAN routes (placeholder dulu, nanti cart/order/tracking kamu/temenmu isi)
 */
Route::middleware(['auth', 'role:pelanggan'])->group(function () {
    // Route::get('/cart', ...);
    // Route::post('/checkout', ...);
});

require __DIR__.'/auth.php';
