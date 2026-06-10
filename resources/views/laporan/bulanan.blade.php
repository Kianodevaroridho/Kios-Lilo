@extends('layouts.app')
@section('title', 'Laporan Bulanan')
@section('page-title', 'Laporan Penjualan Bulanan')
@section('page-subtitle', 'Ringkasan penjualan per bulan')

@section('content')
<div class="flex-between mb-6">
    <form action="{{ route('laporan.bulanan') }}" method="GET" class="flex gap-3">
        <select name="month" class="form-input" style="width:150px">
            @for($m = 1; $m <= 12; $m++)
            <option value="{{ $m }}" {{ $date->month == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create(null, $m)->isoFormat('MMMM') }}
            </option>
            @endfor
        </select>
        <select name="year" class="form-input" style="width:100px">
            @for($y = date('Y'); $y >= date('Y') - 3; $y--)
            <option value="{{ $y }}" {{ $date->year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
    </form>
    <button class="btn btn-outline" onclick="window.print()"><i class="bi bi-printer"></i> Cetak</button>
</div>

<div class="grid grid-3 mb-6">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Total Bulan Ini</h3>
            <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon purple"><i class="bi bi-wallet2"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>Total Transaksi</h3>
            <div class="stat-value">{{ $totalTransactions }}</div>
        </div>
        <div class="stat-icon green"><i class="bi bi-receipt"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>Rata-rata / Hari</h3>
            <div class="stat-value">
                Rp {{ $date->daysInMonth > 0 ? number_format($totalRevenue / $date->daysInMonth, 0, ',', '.') : '0' }}
            </div>
        </div>
        <div class="stat-icon blue"><i class="bi bi-graph-up"></i></div>
    </div>
</div>

{{-- Produk Terlaris --}}
@if($bestSellingProducts->count() > 0)
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">🏆 Produk Terlaris — {{ $date->isoFormat('MMMM YYYY') }}</h3>
    </div>
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead>
                <tr>
                    <th>Peringkat</th>
                    <th>Produk</th>
                    <th>Qty Terjual</th>
                    <th>Total Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bestSellingProducts as $i => $item)
                <tr>
                    <td><strong>#{{ $i + 1 }}</strong></td>
                    <td>{{ $item->product->name ?? '-' }}</td>
                    <td>{{ $item->total_qty }} pcs</td>
                    <td class="text-bold">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Penjualan Harian di Bulan Ini --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">📊 Penjualan Harian — {{ $date->isoFormat('MMMM YYYY') }}</h3>
    </div>
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Total Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailySales as $sale)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($sale->date)->isoFormat('dddd, D MMMM YYYY') }}</td>
                    <td class="text-bold">Rp {{ number_format($sale->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center" style="padding:2rem;color:var(--gray-500)">
                        Tidak ada data penjualan di bulan ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
