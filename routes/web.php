<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Logout (Authenticated Only)
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (All Authenticated Users)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Redirect root to dashboard
    Route::get('/', function () {
        return redirect('/dashboard');
    });

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Kasir / POS
    Route::get('/kasir', function () {
        return view('kasir');
    })->name('kasir');

    // Master Data
    Route::resource('produk', ProductController::class)->parameters([
        'produk' => 'produk'
    ]);

    Route::get('/kategori', function () {
        return view('kategori.index');
    })->name('kategori.index');

    Route::get('/stok', function () {
        return view('stok.index');
    })->name('stok.index');

    // Laporan
    Route::get('/laporan/harian', function () {
        return view('laporan.harian');
    })->name('laporan.harian');

    Route::get('/laporan/bulanan', function () {
        return view('laporan.bulanan');
    })->name('laporan.bulanan');

    Route::get('/transaksi', function () {
        return view('transaksi.index');
    })->name('transaksi.index');

    // Profil
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
});
