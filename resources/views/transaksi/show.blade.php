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
<button class="btn btn-outline" onclick="printReceiptDetail()">
            <i class="bi bi-printer"></i> Cetak Struk
        </button>
        <script>
        function printReceiptDetail(){
            var receipt = document.getElementById('receiptDiv').innerHTML;
            var style = 'body{font-family:monospace;font-size:12px;width:280px;margin:0 auto;padding:10px;color:#000}.center{text-align:center}.bold{font-weight:bold}.line{border-top:1px dashed #000;margin:8px 0}table{width:100%;border-collapse:collapse}th{text-align:left;padding:4px 0;border-bottom:1px solid #000;font-size:11px}.right{text-align:right}.summary td{padding:3px 0}@media print{body{margin:0;padding:5px}}';
            var w = window.open('', '_blank', 'width=350,height=600');
            w.document.write('<!DOCTYPE html><html><head><title>Struk</title><style>'+style+'</style></head><body>'+receipt+'</body></html>');
            w.document.close();
            w.print();
        }
        </script>
        <div id="receiptDiv" style="display:none;">
            <div class="center bold" style="font-size:16px">KIOS LILO</div>
            <div class="center" style="font-size:11px">Pasar Muka Ramayana Cianjur, Lantai Dasar, Blok D No. 23</div>
            <div class="center" style="font-size:11px">Telp: 0819-1229-9111</div>
            <div class="line"></div>
            <div style="font-size:11px">No: TRX-{{ str_pad($transaksi->id,5,'0',STR_PAD_LEFT) }}</div>
            <div style="font-size:11px">Tanggal: {{ $transaksi->created_at->format('d M Y') }}</div>
            <div style="font-size:11px">Waktu: {{ $transaksi->created_at->format('H:i') }}</div>
            <div style="font-size:11px">Kasir: {{ $transaksi->user->name ?? 'Admin' }}</div>
            <div class="line"></div>
            <table><thead><tr><th>Item</th><th style="text-align:center">Qty</th><th style="text-align:right">Harga</th><th style="text-align:right">Subtotal</th></tr></thead><tbody>
            @foreach($transaksi->details as $detail)
            <tr>
                <td style="padding:4px 0;">{{ $detail->product->name ?? 'Produk dihapus' }}</td>
                <td style="text-align:center;padding:4px 0;">{{ $detail->qty }}</td>
                <td style="text-align:right;padding:4px 0;">Rp {{ number_format($detail->price,0,',','.') }}</td>
                <td style="text-align:right;padding:4px 0;">Rp {{ number_format($detail->price * $detail->qty,0,',','.') }}</td>
            </tr>
            @endforeach
            </tbody></table>
            <div class="line"></div>
            <table class="summary"><tr><td class="bold">TOTAL</td><td class="right bold" style="font-size:14px">Rp {{ number_format($transaksi->total,0,',','.') }}</td></tr>
            <tr><td>Bayar</td><td class="right">Rp {{ number_format($transaksi->payment,0,',','.') }}</td></tr>
            <tr><td>Kembali</td><td class="right">Rp {{ number_format($transaksi->change,0,',','.') }}</td></tr></table>
            <div class="line"></div>
            <div class="center" style="font-size:11px">Terima kasih telah berbelanja!</div>
            <div class="center" style="font-size:10px;margin-top:4px">~ Kios Lilo POS ~</div>
        </div>
        <a href="{{ route('transaksi.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
        </a>
    </div>
</div>
@endsection
