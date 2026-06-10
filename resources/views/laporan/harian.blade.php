@extends('layouts.app')
@section('title', 'Laporan Harian')
@section('page-title', 'Laporan Penjualan Harian')
@section('page-subtitle', 'Ringkasan penjualan hari ini')

@section('content')
<div class="flex-between mb-6">
    <form action="{{ route('laporan.harian') }}" method="GET" class="flex gap-3">
        <input type="date" name="date" class="form-input" style="width:200px" value="{{ $date->format('Y-m-d') }}">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
    </form>
    <button class="btn btn-outline" onclick="window.print()"><i class="bi bi-printer"></i> Cetak</button>
</div>

<div class="grid grid-3 mb-6">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Total Penjualan</h3>
            <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon purple"><i class="bi bi-wallet2"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>Jumlah Transaksi</h3>
            <div class="stat-value">{{ $totalTransactions }}</div>
        </div>
        <div class="stat-icon green"><i class="bi bi-receipt"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>Rata-rata / Transaksi</h3>
            <div class="stat-value">
                Rp {{ $totalTransactions > 0 ? number_format($totalRevenue / $totalTransactions, 0, ',', '.') : '0' }}
            </div>
        </div>
        <div class="stat-icon blue"><i class="bi bi-graph-up"></i></div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">📋 Daftar Transaksi — {{ $date->isoFormat('dddd, D MMMM YYYY') }}</h3>
    </div>
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Waktu</th>
                    <th>Kasir</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Bayar</th>
                    <th>Kembali</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td><strong>#TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $trx->created_at->format('H:i') }}</td>
                    <td>{{ $trx->user->name ?? 'Admin' }}</td>
                    <td>{{ $trx->details->count() }} item</td>
                    <td class="text-bold">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($trx->payment, 0, ',', '.') }}</td>
                    <td class="text-success">Rp {{ number_format($trx->change, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding:2rem;color:var(--gray-500)">
                        <i class="bi bi-receipt" style="font-size:2rem;display:block;margin-bottom:0.5rem"></i>
                        Tidak ada transaksi pada tanggal ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
