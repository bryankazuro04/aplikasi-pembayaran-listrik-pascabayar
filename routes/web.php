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

Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
Route::resources([
    'pelanggan' => PelangganController::class,
    'tagihan' => TagihanController::class, 
    'pembayaran' => PembayaranController::class, 
    'penggunaan' => PenggunaanController::class, 
    'tarif' => TarifController::class
]);

Route::get('/pelanggan/search', [PelangganController::class, 'search'])->name('pelanggan.search');


// Route::middleware(['auth'])->group(function () {
// });

// Route::middleware(['auth:pelanggan'])->group(function () {
// });
// Route::resource('pelanggan', PelangganController::class);



Route::get('/pelanggan/get-by-nomor-kwh', [PelangganController::class, 'getByNomorKwh'])->name('pelanggan.getByNomorKwh');