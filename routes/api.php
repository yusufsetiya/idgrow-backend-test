<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProdukLokasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('kategori', KategoriController::class);
    Route::apiResource('lokasi', LokasiController::class);
    Route::apiResource('produk', ProdukController::class);
    Route::apiResource('produk-lokasi', ProdukLokasiController::class);
    Route::apiResource('mutasi', MutasiController::class);
    Route::get('mutasi/produk/{produkId}', [MutasiController::class, 'historyByProduk']);
    Route::get('mutasi/user/{userId}', [MutasiController::class, 'historyByUser']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


