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
    return view('auth.login'); // Sesuaikan 'auth.login' dengan nama file blade login Anda
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
    Route::resource('payment-methods', \App\Http\Controllers\Dashboard\PaymentMethodController::class);
    Route::resource('settings', \App\Http\Controllers\Dashboard\SettingController::class)->only(['index']);

    Route::get('profile', [\App\Http\Controllers\Dashboard\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [\App\Http\Controllers\Dashboard\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [\App\Http\Controllers\Dashboard\ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::delete('/dashboard/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('dashboard.transaksi.destroy');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('dashboard.users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

Route::get('/admin/users/{user}/role', function() {
    return redirect()->route('dashboard.users.index');
});

// Add this inside the dashboard route group
Route::prefix('payment-methods')->name('payment-methods.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Dashboard\PaymentMethodController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\Dashboard\PaymentMethodController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\Dashboard\PaymentMethodController::class, 'store'])->name('store');
    Route::get('/{paymentMethod}/edit', [\App\Http\Controllers\Dashboard\PaymentMethodController::class, 'edit'])->name('edit');
    Route::put('/{paymentMethod}', [\App\Http\Controllers\Dashboard\PaymentMethodController::class, 'update'])->name('update');
    Route::delete('/{paymentMethod}', [\App\Http\Controllers\Dashboard\PaymentMethodController::class, 'destroy'])->name('destroy');
});

Route::get('/transaksi/pdf', [TransaksiController::class, 'exportPdf'])->name('transaksi.pdf');
Route::get('/transaksi/export', [TransaksiController::class, 'exportExcel'])->name('transaksi.export');