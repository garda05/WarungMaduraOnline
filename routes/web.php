<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    BarangController,
    DashboardController,
    KeranjangController,
    PesananController,
    ChatController
};

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PEMBELI
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:pembeli')->group(function () {

        Route::delete('/pesanan/hapus-history', [PesananController::class, 'hapusHistoryPembeli'])
            ->name('pesanan.hapusHistory');

        Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
        Route::post('/keranjang/tambah/{barang}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
        Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
        Route::post('/keranjang/pesan', [KeranjangController::class, 'pesan'])->name('keranjang.pesan');

        Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::post('/pesanan/{pesanan}/bayar', [PesananController::class, 'konfirmasiPembayaran'])->name('pesanan.bayar');
        Route::delete('/pesanan/{pesanan}', [PesananController::class, 'batal'])->name('pesanan.batal');
    });

    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])
        ->name('pesanan.show');

    /*
    |--------------------------------------------------------------------------
    | PENJUAL
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:penjual')->group(function () {

        Route::resource('barang', BarangController::class);

        Route::delete('/penjual/pesanan/hapus-history', [PesananController::class, 'hapusHistoryPenjual'])
            ->name('penjual.pesanan.hapusHistory');

        Route::get('/penjual/pesanan', [PesananController::class, 'indexPenjual'])
            ->name('penjual.pesanan');

        Route::patch('/penjual/pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])
            ->name('pesanan.updateStatus');
    });

    /*
    |--------------------------------------------------------------------------
    | CHAT
    |--------------------------------------------------------------------------
    */
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
