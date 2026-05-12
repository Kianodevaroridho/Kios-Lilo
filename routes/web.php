<?php

use App\Http\Controllers\AuthController;
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
| Protected Routes (Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Redirect root to dashboard
    Route::get('/', function () {
        $user = auth()->user();
        return redirect($user->isAdmin() ? '/dashboard' : '/kasir');
    });

    /*
    |----------------------------------------------------------------------
    | Admin Only Routes
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Master Data
        Route::get('/produk', function () {
            return view('produk.index');
        })->name('produk.index');

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
    });

    /*
    |----------------------------------------------------------------------
    | Admin & Kasir Routes
    |----------------------------------------------------------------------
    */
    Route::middleware('role:admin,kasir')->group(function () {
        Route::get('/kasir', function () {
            return view('kasir');
        })->name('kasir');

        Route::get('/profil', function () {
            return view('profil');
        })->name('profil');
    });
});
