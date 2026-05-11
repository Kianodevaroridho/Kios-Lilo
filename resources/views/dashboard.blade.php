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
            <div class="stat-value">Rp 2.450.000</div>
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
            <div class="stat-value">48</div>
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
            <div class="stat-value">156</div>
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
            <div class="stat-value">7</div>
            <span class="stat-change negative">
                <i class="bi bi-exclamation-triangle"></i> Perlu restock
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
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height: 45%;" data-value="Rp 1.2jt">
                            <span class="chart-tooltip">Rp 1.200.000</span>
                        </div>
                        <span class="chart-label">Sen</span>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height: 65%;" data-value="Rp 1.8jt">
                            <span class="chart-tooltip">Rp 1.800.000</span>
                        </div>
                        <span class="chart-label">Sel</span>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height: 55%;" data-value="Rp 1.5jt">
                            <span class="chart-tooltip">Rp 1.500.000</span>
                        </div>
                        <span class="chart-label">Rab</span>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height: 80%;" data-value="Rp 2.3jt">
                            <span class="chart-tooltip">Rp 2.300.000</span>
                        </div>
                        <span class="chart-label">Kam</span>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height: 70%;" data-value="Rp 2.0jt">
                            <span class="chart-tooltip">Rp 2.000.000</span>
                        </div>
                        <span class="chart-label">Jum</span>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar highlight" style="height: 90%;" data-value="Rp 2.5jt">
                            <span class="chart-tooltip">Rp 2.450.000</span>
                        </div>
                        <span class="chart-label">Sab</span>
                    </div>
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height: 40%;" data-value="Rp 1.1jt">
                            <span class="chart-tooltip">Rp 1.100.000</span>
                        </div>
                        <span class="chart-label">Min</span>
                    </div>
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
                    <tr>
                        <td><span class="rank rank-1">1</span></td>
                        <td><strong>Indomie Goreng</strong></td>
                        <td>342</td>
                        <td class="text-bold">Rp 1.026.000</td>
                    </tr>
                    <tr>
                        <td><span class="rank rank-2">2</span></td>
                        <td><strong>Aqua 600ml</strong></td>
                        <td>289</td>
                        <td class="text-bold">Rp 1.156.000</td>
                    </tr>
                    <tr>
                        <td><span class="rank rank-3">3</span></td>
                        <td><strong>Teh Botol Sosro</strong></td>
                        <td>215</td>
                        <td class="text-bold">Rp 860.000</td>
                    </tr>
                    <tr>
                        <td><span class="rank">4</span></td>
                        <td><strong>Rokok Gudang Garam</strong></td>
                        <td>198</td>
                        <td class="text-bold">Rp 5.940.000</td>
                    </tr>
                    <tr>
                        <td><span class="rank">5</span></td>
                        <td><strong>Beras 5kg</strong></td>
                        <td>87</td>
                        <td class="text-bold">Rp 5.655.000</td>
                    </tr>
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
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>#TRX-20260511-001</strong></td>
                    <td>14:32</td>
                    <td>Admin</td>
                    <td>5 item</td>
                    <td class="text-bold">Rp 87.500</td>
                    <td><span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span></td>
                </tr>
                <tr>
                    <td><strong>#TRX-20260511-002</strong></td>
                    <td>13:18</td>
                    <td>Admin</td>
                    <td>3 item</td>
                    <td class="text-bold">Rp 45.000</td>
                    <td><span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span></td>
                </tr>
                <tr>
                    <td><strong>#TRX-20260511-003</strong></td>
                    <td>12:05</td>
                    <td>Admin</td>
                    <td>8 item</td>
                    <td class="text-bold">Rp 156.000</td>
                    <td><span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span></td>
                </tr>
                <tr>
                    <td><strong>#TRX-20260511-004</strong></td>
                    <td>11:42</td>
                    <td>Admin</td>
                    <td>2 item</td>
                    <td class="text-bold">Rp 23.000</td>
                    <td><span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span></td>
                </tr>
                <tr>
                    <td><strong>#TRX-20260511-005</strong></td>
                    <td>10:15</td>
                    <td>Admin</td>
                    <td>6 item</td>
                    <td class="text-bold">Rp 112.500</td>
                    <td><span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span></td>
                </tr>
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
