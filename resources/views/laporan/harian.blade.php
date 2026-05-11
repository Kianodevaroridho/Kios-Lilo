@extends('layouts.app')
@section('title', 'Laporan Harian')
@section('page-title', 'Laporan Penjualan Harian')
@section('page-subtitle', 'Ringkasan penjualan hari ini')

@section('content')
<div class="flex-between mb-6">
    <div class="flex gap-3">
        <input type="date" class="form-input" style="width:200px" value="{{ date('Y-m-d') }}">
        <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
    </div>
    <button class="btn btn-outline"><i class="bi bi-download"></i> Export PDF</button>
</div>

<div class="grid grid-3 mb-6">
    <div class="stat-card"><div class="stat-info"><h3>Total Penjualan</h3><div class="stat-value">Rp 2.450.000</div></div><div class="stat-icon purple"><i class="bi bi-wallet2"></i></div></div>
    <div class="stat-card"><div class="stat-info"><h3>Jumlah Transaksi</h3><div class="stat-value">48</div></div><div class="stat-icon green"><i class="bi bi-receipt"></i></div></div>
    <div class="stat-card"><div class="stat-info"><h3>Rata-rata / Transaksi</h3><div class="stat-value">Rp 51.042</div></div><div class="stat-icon blue"><i class="bi bi-graph-up"></i></div></div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title">📋 Daftar Transaksi Hari Ini</h3></div>
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead><tr><th>No. Transaksi</th><th>Waktu</th><th>Items</th><th>Total</th><th>Bayar</th><th>Kembali</th></tr></thead>
            <tbody>
                @php $trx = [['#TRX-001','08:15',3,45000,50000],['#TRX-002','09:32',5,87500,100000],['#TRX-003','10:48',2,23000,25000],['#TRX-004','12:05',8,156000,160000],['#TRX-005','13:18',4,68000,70000],['#TRX-006','14:32',6,112500,120000]]; @endphp
                @foreach($trx as $t)
                <tr>
                    <td><strong>{{ $t[0] }}</strong></td>
                    <td>{{ $t[1] }}</td>
                    <td>{{ $t[2] }} item</td>
                    <td class="text-bold">Rp {{ number_format($t[3],0,',','.') }}</td>
                    <td>Rp {{ number_format($t[4],0,',','.') }}</td>
                    <td class="text-success">Rp {{ number_format($t[4]-$t[3],0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
