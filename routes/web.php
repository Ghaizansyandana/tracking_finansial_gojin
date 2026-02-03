<?php

use App\Http\Controllers\Dashboard\AkunKeuanganController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\TransaksiController; // Pastikan ini ada di paling atas
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\KategoriKeuanganController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// inventaris
Auth::routes(['register' => false]);

// tracking
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard routes
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');
    Route::resource('users', App\Http\Controllers\Dashboard\UserController::class);
    Route::resource('akuns', App\Http\Controllers\Dashboard\AkunKeuanganController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('kategori', KategoriKeuanganController::class);
});
