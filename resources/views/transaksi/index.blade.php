@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'Semua transaksi yang telah dilakukan')

@section('content')
<div class="flex-between mb-6">
    <form action="{{ route('transaksi.index') }}" method="GET" class="flex gap-3">
        <input type="date" name="from" class="form-input" style="width:160px" value="{{ request('from') }}">
        <input type="date" name="to" class="form-input" style="width:160px" value="{{ request('to') }}">
        <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
        @if(request('from') || request('to'))
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline">Reset</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Tanggal</th>
                    <th>Kasir</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $i => $trx)
                <tr>
                    <td><strong>#TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $trx->created_at->format('d M Y, H:i') }}</td>
                    <td>{{ $trx->user->name ?? 'Admin' }}</td>
                    <td>{{ $trx->details->count() }} item</td>
                    <td class="text-bold">Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                    <td><span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span></td>
                    <td>
                        <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-outline">
                            <i class="bi bi-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding:2rem;color:var(--gray-500)">
                        <i class="bi bi-receipt" style="font-size:2rem;display:block;margin-bottom:0.5rem"></i>
                        Belum ada transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="pagination mt-4">
    {{ $transactions->links() }}
</div>
@endsection
