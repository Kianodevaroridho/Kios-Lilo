<?php

use Illuminate\Support\Facades\Route;

// Redirect root to dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
});

// Kasir / POS
Route::get('/kasir', function () {
    return view('kasir');
});

// Master Data
Route::get('/produk', function () {
    return view('produk.index');
});

Route::get('/kategori', function () {
    return view('kategori.index');
});

Route::get('/stok', function () {
    return view('stok.index');
});

// Laporan
Route::get('/laporan/harian', function () {
    return view('laporan.harian');
});

Route::get('/laporan/bulanan', function () {
    return view('laporan.bulanan');
});

Route::get('/transaksi', function () {
    return view('transaksi.index');
});

// Profil
Route::get('/profil', function () {
    return view('profil');
});
