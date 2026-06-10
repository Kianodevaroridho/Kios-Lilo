@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')
@section('page-subtitle', 'Rincian transaksi #TRX-{{ str_pad($transaksi->id, 5, "0", STR_PAD_LEFT) }}')

@section('content')
<div style="max-width:700px">
    {{-- Header Card --}}
    <div class="card mb-6">
        <div class="card-header">
            <h3 class="card-title">🧾 Transaksi #TRX-{{ str_pad($transaksi->id, 5, '0', STR_PAD_LEFT) }}</h3>
            <a href="{{ route('transaksi.index') }}" class="btn btn-sm btn-outline"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <div class="grid grid-3" style="gap:1rem">
                <div>
                    <p class="text-muted" style="font-size:0.8rem;margin-bottom:0.25rem">Tanggal & Waktu</p>
                    <p style="font-weight:600">{{ $transaksi->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-muted" style="font-size:0.8rem;margin-bottom:0.25rem">Kasir</p>
                    <p style="font-weight:600">{{ $transaksi->user->name ?? 'Admin' }}</p>
                </div>
                <div>
                    <p class="text-muted" style="font-size:0.8rem;margin-bottom:0.25rem">Status</p>
                    <span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="card mb-6">
        <div class="card-header">
            <h3 class="card-title">📦 Daftar Item</h3>
            <span class="badge badge-info">{{ $transaksi->details->count() }} produk</span>
        </div>
        <div class="card-body" style="padding:0">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th>Harga Satuan</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->details as $i => $detail)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><strong>{{ $detail->product->name ?? 'Produk dihapus' }}</strong></td>
                        <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td class="text-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ringkasan Pembayaran --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">💳 Ringkasan Pembayaran</h3>
        </div>
        <div class="card-body">
            <div style="display:flex;flex-direction:column;gap:0.75rem">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span class="text-muted">Total Belanja</span>
                    <span style="font-weight:700;font-size:1.1rem">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span class="text-muted">Pembayaran</span>
                    <span>Rp {{ number_format($transaksi->payment, 0, ',', '.') }}</span>
                </div>
                <hr style="border:none;border-top:1px solid var(--gray-200)">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span style="font-weight:600">Kembalian</span>
                    <span style="font-weight:700;color:var(--success);font-size:1.1rem">
                        Rp {{ number_format($transaksi->change, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex gap-3 mt-6">
        <button class="btn btn-outline" onclick="window.print()">
            <i class="bi bi-printer"></i> Cetak Struk
        </button>
        <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
        </a>
    </div>
</div>
@endsection
