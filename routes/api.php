<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BarangController;

// AUTH API
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// PROTECTED API
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // CRUD API BARANG
    Route::get('/barang', [BarangController::class, 'index']);          // GET ALL
    Route::post('/barang', [BarangController::class, 'store']);         // CREATE
    Route::get('/barang/{id}', [BarangController::class, 'show']);      // DETAIL
    Route::put('/barang/{id}', [BarangController::class, 'update']);    // UPDATE
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']); // DELETE
});
