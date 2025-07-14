<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\TarifController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/pelanggan/search', [PelangganController::class, 'search'])->name('pelanggan.search');


Route::middleware(['auth:web', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resources([
        'pelanggan' => PelangganController::class,
        'pembayaran' => PembayaranController::class, 
        'penggunaan' => PenggunaanController::class, 
        'tarif' => TarifController::class
    ]);
});

Route::middleware(['auth:pelanggan', 'pelanggan'])->group(function () {
    Route::get('/pembayaran/create/{id}', [PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::resource('tagihan', TagihanController::class);
});
// Route::resource('pelanggan', PelangganController::class);


Route::get('/pelanggan/get-by-nomor-kwh', [PelangganController::class, 'getByNomorKwh'])->name('pelanggan.getByNomorKwh');