<?php

use App\Http\Controllers\Dashboard\AkunKeuanganController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\TransaksiController; // Pastikan ini ada di paling atas
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Auth\LoginController; // <--- Pastikan baris ini ada!
use App\Http\Controllers\Dashboard\KategoriKeuanganController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// inventaris
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// tracking
// Auth::routes();
// Pastikan ada ->name('login') di ujungnya
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    
    // Pastikan menggunakan panah (->) bukan titik (.)
    $request->session()->invalidate(); 
    $request->session()->regenerateToken();
    
    return redirect('/');
})->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard routes
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\Dashboard\DashboardController::class, 'index'])->name('index');
    Route::resource('users', App\Http\Controllers\Dashboard\UserController::class);
    Route::resource('akuns', App\Http\Controllers\Dashboard\AkunKeuanganController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('kategori', KategoriKeuanganController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('dashboard.users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

Route::get('/admin/users/{user}/role', function() {
    return redirect()->route('dashboard.users.index');
});



