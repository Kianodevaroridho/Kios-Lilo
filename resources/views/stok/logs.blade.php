@extends('layouts.app')
@section('title', 'Riwayat Stok')
@section('page-title', 'Riwayat Perubahan Stok')
@section('page-subtitle', 'Log masuk dan keluar stok semua produk')

@section('content')
<div class="flex-between mb-6">
    <a href="{{ route('stok.index') }}" class="btn btn-sm btn-outline">
        <i class="bi bi-arrow-left"></i> Kembali ke Stok
    </a>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Produk</th>
                    <th>Tipe</th>
                    <th>Qty</th>
                    <th>Stok Sebelum</th>
                    <th>Stok Sesudah</th>
                    <th>Keterangan</th>
                    <th>Oleh</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td style="white-space:nowrap">{{ $log->created_at->format('d M Y, H:i') }}</td>
                    <td><strong>{{ $log->product->name ?? 'Produk dihapus' }}</strong></td>
                    <td>
                        @if($log->type === 'in')
                            <span class="badge badge-success"><i class="bi bi-arrow-down-circle"></i> Masuk</span>
                        @else
                            <span class="badge badge-danger"><i class="bi bi-arrow-up-circle"></i> Keluar</span>
                        @endif
                    </td>
                    <td>
                        <strong class="{{ $log->type === 'in' ? 'text-success' : 'text-danger' }}">
                            {{ $log->type === 'in' ? '+' : '-' }}{{ $log->qty }}
                        </strong>
                    </td>
                    <td>{{ $log->stock_before }}</td>
                    <td><strong>{{ $log->stock_after }}</strong></td>
                    <td class="text-muted" style="font-size:0.85rem">{{ $log->description ?? '-' }}</td>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding:2rem;color:var(--gray-500)">
                        <i class="bi bi-clipboard-x" style="font-size:2rem;display:block;margin-bottom:0.5rem"></i>
                        Belum ada riwayat perubahan stok.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination mt-4">
    {{ $logs->links() }}
</div>
@endsection
