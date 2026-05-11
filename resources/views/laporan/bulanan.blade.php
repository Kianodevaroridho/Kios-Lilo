@extends('layouts.app')
@section('title', 'Laporan Bulanan')
@section('page-title', 'Laporan Penjualan Bulanan')
@section('page-subtitle', 'Ringkasan penjualan per bulan')

@section('content')
<div class="flex-between mb-6">
    <div class="flex gap-3">
        <select class="form-input" style="width:150px">
            <option>Mei 2026</option><option>April 2026</option><option>Maret 2026</option>
        </select>
        <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
    </div>
    <button class="btn btn-outline"><i class="bi bi-download"></i> Export Excel</button>
</div>

<div class="grid grid-4 mb-6">
    <div class="stat-card"><div class="stat-info"><h3>Total Bulan Ini</h3><div class="stat-value">Rp 45.8jt</div></div><div class="stat-icon purple"><i class="bi bi-wallet2"></i></div></div>
    <div class="stat-card"><div class="stat-info"><h3>Total Transaksi</h3><div class="stat-value">892</div></div><div class="stat-icon green"><i class="bi bi-receipt"></i></div></div>
    <div class="stat-card"><div class="stat-info"><h3>Rata-rata / Hari</h3><div class="stat-value">Rp 1.5jt</div></div><div class="stat-icon blue"><i class="bi bi-graph-up"></i></div></div>
    <div class="stat-card"><div class="stat-info"><h3>vs Bulan Lalu</h3><div class="stat-value">+12%</div><span class="stat-change positive"><i class="bi bi-arrow-up-short"></i> Naik</span></div><div class="stat-icon green"><i class="bi bi-trending-up"></i></div></div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title">📊 Penjualan Per Minggu</h3></div>
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead><tr><th>Minggu</th><th>Periode</th><th>Transaksi</th><th>Total</th><th>Trend</th></tr></thead>
            <tbody>
                <tr><td><strong>Minggu 1</strong></td><td>1 - 7 Mei</td><td>198</td><td class="text-bold">Rp 10.200.000</td><td><span class="badge badge-success"><i class="bi bi-arrow-up"></i> +5%</span></td></tr>
                <tr><td><strong>Minggu 2</strong></td><td>8 - 14 Mei</td><td>215</td><td class="text-bold">Rp 12.350.000</td><td><span class="badge badge-success"><i class="bi bi-arrow-up"></i> +21%</span></td></tr>
                <tr><td><strong>Minggu 3</strong></td><td>15 - 21 Mei</td><td>187</td><td class="text-bold">Rp 9.800.000</td><td><span class="badge badge-danger"><i class="bi bi-arrow-down"></i> -20%</span></td></tr>
                <tr><td><strong>Minggu 4</strong></td><td>22 - 28 Mei</td><td>225</td><td class="text-bold">Rp 13.450.000</td><td><span class="badge badge-success"><i class="bi bi-arrow-up"></i> +37%</span></td></tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
