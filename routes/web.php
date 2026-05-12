<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ReportController;
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

    Route::resource('kategori', CategoryController::class)->parameters([
        'kategori' => 'kategori'
    ]);

    // Manajemen Stok
    Route::get('/stok', [StockController::class, 'index'])->name('stok.index');
    Route::post('/stok/restock', [StockController::class, 'restock'])->name('stok.restock');
    Route::get('/stok/logs', [StockController::class, 'logs'])->name('stok.logs');

    // Laporan
    Route::get('/laporan/harian', [ReportController::class, 'daily'])->name('laporan.harian');
    Route::get('/laporan/bulanan', [ReportController::class, 'monthly'])->name('laporan.bulanan');

    Route::get('/transaksi', [TransactionController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{transaksi}', [TransactionController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi', [TransactionController::class, 'store'])->name('transaksi.store');

    // Profil
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
});
