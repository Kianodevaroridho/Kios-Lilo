@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan penjualan dan aktivitas toko hari ini')

@section('content')

{{-- Stat Cards --}}
<div class="grid grid-4">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Penjualan Hari Ini</h3>
            <div class="stat-value">Rp {{ number_format($totalRevenueToday, 0, ',', '.') }}</div>
            <span class="stat-change positive">
                <i class="bi bi-arrow-up-short"></i> +12.5%
            </span>
        </div>
        <div class="stat-icon purple">
            <i class="bi bi-wallet2"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Total Transaksi</h3>
            <div class="stat-value">{{ $totalTransactionsToday }}</div>
            <span class="stat-change positive">
                <i class="bi bi-arrow-up-short"></i> +8.3%
            </span>
        </div>
        <div class="stat-icon green">
            <i class="bi bi-receipt"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Jumlah Produk</h3>
            <div class="stat-value">{{ $totalProducts }}</div>
            <span class="stat-change positive">
                <i class="bi bi-arrow-up-short"></i> +3
            </span>
        </div>
        <div class="stat-icon blue">
            <i class="bi bi-box-seam"></i>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3>Stok Menipis</h3>
            <div class="stat-value">{{ $lowStockCount }}</div>
            <span class="stat-change {{ $lowStockCount > 0 ? 'negative' : 'positive' }}">
                <i class="bi {{ $lowStockCount > 0 ? 'bi-exclamation-triangle' : 'bi-check-circle' }}"></i> 
                {{ $lowStockCount > 0 ? 'Perlu restock' : 'Stok aman' }}
            </span>
        </div>
        <div class="stat-icon red">
            <i class="bi bi-archive"></i>
        </div>
    </div>
</div>

{{-- Charts & Tables Row --}}
<div class="grid grid-2 mt-6">
    {{-- Sales Chart --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📊 Penjualan 7 Hari Terakhir</h3>
            <span class="badge badge-info">Minggu Ini</span>
        </div>
        <div class="card-body">
            <div class="chart-placeholder" id="salesChart">
                <div class="chart-bars">
                    @php 
                        $max = count($salesData) > 0 ? max($salesData) : 0;
                        if ($max == 0) $max = 1;
                    @endphp
                    @foreach($salesData as $index => $revenue)
                    <div class="chart-bar-group">
                        <div class="chart-bar {{ $index == 6 ? 'highlight' : '' }}" style="height: {{ ($revenue / $max) * 90 }}%;" data-value="Rp {{ number_format($revenue/1000, 1) }}k">
                            <span class="chart-tooltip">Rp {{ number_format($revenue, 0, ',', '.') }}</span>
                        </div>
                        <span class="chart-label">{{ $days[$index] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Top Products --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">🏆 Produk Terlaris</h3>
            <span class="badge badge-success">Bulan Ini</span>
        </div>
        <div class="card-body" style="padding: 0;">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Terjual</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topProducts as $index => $item)
                    <tr>
                        <td><span class="rank rank-{{ $index + 1 }}">{{ $index + 1 }}</span></td>
                        <td><strong>{{ $item->product->name }}</strong></td>
                        <td>{{ $item->total_qty }}</td>
                        <td class="text-bold">Rp {{ number_format($item->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data penjualan bulan ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Recent Transactions --}}
<div class="card mt-6">
    <div class="card-header">
        <h3 class="card-title">🕐 Transaksi Terbaru</h3>
        <a href="{{ url('/transaksi') }}" class="btn btn-outline btn-sm">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Waktu</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $trx)
                <tr>
                    <td><strong>#TRX-{{ $trx->created_at->format('Ymd') }}-{{ str_pad($trx->id, 3, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $trx->created_at->format('H:i') }}</td>
                    <td>{{ $trx->user->name }}</td>
                    <td class="text-bold">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada transaksi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Chart Styles */
.chart-placeholder {
    padding: var(--space-4) 0;
}

.chart-bars {
    display: flex;
    align-items: flex-end;
    justify-content: space-around;
    height: 220px;
    padding: 0 var(--space-2);
}

.chart-bar-group {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--space-2);
    flex: 1;
}

.chart-bar {
    width: 36px;
    background: linear-gradient(180deg, var(--primary-light), var(--primary));
    border-radius: 6px 6px 0 0;
    position: relative;
    transition: all 0.4s ease;
    cursor: pointer;
    min-height: 10px;
}

.chart-bar:hover {
    background: linear-gradient(180deg, var(--accent-light), var(--accent));
    transform: scaleY(1.05);
}

.chart-bar.highlight {
    background: linear-gradient(180deg, var(--accent-light), var(--accent));
    box-shadow: 0 4px 15px rgba(0, 206, 201, 0.3);
}

.chart-tooltip {
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: var(--dark);
    color: var(--white);
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.65rem;
    font-weight: 600;
    white-space: nowrap;
    opacity: 0;
    transition: var(--transition-fast);
    pointer-events: none;
}

.chart-bar:hover .chart-tooltip {
    opacity: 1;
}

.chart-label {
    font-size: var(--font-size-xs);
    color: var(--gray-500);
    font-weight: 600;
}

/* Rank Badges */
.rank {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: var(--radius-full);
    font-size: var(--font-size-xs);
    font-weight: 700;
    background: var(--gray-100);
    color: var(--gray-600);
}

.rank-1 { background: linear-gradient(135deg, #FFD700, #FFA502); color: #fff; }
.rank-2 { background: linear-gradient(135deg, #C0C0C0, #95A5A6); color: #fff; }
.rank-3 { background: linear-gradient(135deg, #CD7F32, #E17055); color: #fff; }
</style>
@endpush
