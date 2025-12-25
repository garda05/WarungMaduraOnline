<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeranjangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// DASHBOARD
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // =========================
    // PEMBELI - KERANJANG
    // =========================
    Route::middleware(['auth', 'role:pembeli'])->group(function () {
        Route::get('/keranjang', [KeranjangController::class, 'index'])
            ->name('keranjang.index');

        Route::post('/keranjang/tambah/{barang}', [KeranjangController::class, 'tambah'])
            ->name('keranjang.tambah');

        Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])
            ->name('keranjang.hapus');

        Route::post('/keranjang/pesan', [KeranjangController::class, 'pesan'])
            ->name('keranjang.pesan');
    });

    // =========================
    // PESANAN
    // =========================
    Route::get('/pesanan', function () {
        return view('pesanan.index');
    })->name('pesanan.index');

    // =========================
    // CHAT
    // =========================
    Route::get('/chat', function () {
        return view('chat.index');
    })->name('chat.index');

    // =========================
    // PROFILE
    // =========================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =========================
// PENJUAL - KELOLA PRODUK
// =========================
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::resource('barang', BarangController::class);
});

require __DIR__ . '/auth.php';
