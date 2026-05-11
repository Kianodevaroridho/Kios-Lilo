@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')
@section('page-subtitle', 'Semua transaksi yang telah dilakukan')

@section('content')
<div class="flex-between mb-6">
    <div class="flex gap-3">
        <input type="date" class="form-input" style="width:160px">
        <input type="date" class="form-input" style="width:160px">
        <button class="btn btn-primary"><i class="bi bi-funnel"></i> Filter</button>
    </div>
</div>

<div class="card">
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead><tr><th>No. Transaksi</th><th>Tanggal</th><th>Kasir</th><th>Items</th><th>Total</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @php $data = [['TRX-20260511-001','11 Mei 2026, 14:32','Admin',5,87500],['TRX-20260511-002','11 Mei 2026, 13:18','Admin',3,45000],['TRX-20260511-003','11 Mei 2026, 12:05','Admin',8,156000],['TRX-20260510-001','10 Mei 2026, 16:45','Admin',4,68000],['TRX-20260510-002','10 Mei 2026, 11:20','Admin',6,92000],['TRX-20260509-001','9 Mei 2026, 15:10','Admin',2,35000]]; @endphp
                @foreach($data as $t)
                <tr>
                    <td><strong>#{{ $t[0] }}</strong></td>
                    <td>{{ $t[1] }}</td>
                    <td>{{ $t[2] }}</td>
                    <td>{{ $t[3] }} item</td>
                    <td class="text-bold">Rp {{ number_format($t[4],0,',','.') }}</td>
                    <td><span class="badge badge-success"><i class="bi bi-check-circle"></i> Lunas</span></td>
                    <td><button class="btn btn-sm btn-outline"><i class="bi bi-eye"></i> Detail</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
