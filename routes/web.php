<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // KERANJANG (Pembeli only)
    Route::middleware('role:pembeli')->group(function () {
        Route::get('/keranjang', function () {
            return view('keranjang.index');
        })->name('keranjang.index');
    });

    // PESANAN (Semua user)
    Route::get('/pesanan', function () {
        return view('pesanan.index');
    })->name('pesanan.index');

    // CHAT (Semua user)
    Route::get('/chat', function () {
        return view('chat.index');
    })->name('chat.index');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// PENJUAL: Kelola Produk
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::resource('barang', BarangController::class);
});

require __DIR__.'/auth.php';
