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

Route::middleware(['auth:web', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/pelanggan/search', [PelangganController::class, 'search'])->name('pelanggan.search');
    Route::resources([
        'pelanggan' => PelangganController::class,
        'penggunaan' => PenggunaanController::class,
        'tarif' => TarifController::class,
    ]);
    Route::resource('pembayaran', PembayaranController::class)->except(['store', 'show']);
});

Route::middleware(['auth:pelanggan', 'pelanggan'])->group(function () {
    Route::get('/home', [PelangganController::class, 'home'])->name('pelanggan.home');
    Route::resource('pembayaran', PembayaranController::class)->only(['store', 'show']);
});

Route::resource('tagihan', TagihanController::class);