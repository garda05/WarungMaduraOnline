<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (wajib login & verified)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Semua fitur setelah login
Route::middleware(['auth'])->group(function () {

    // CRUD BARANG
    Route::resource('barang', BarangController::class);

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
