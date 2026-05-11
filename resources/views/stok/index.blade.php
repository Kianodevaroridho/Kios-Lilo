@extends('layouts.app')
@section('title', 'Stok')
@section('page-title', 'Manajemen Stok')
@section('page-subtitle', 'Pantau dan kelola stok produk')

@section('content')
<div class="grid grid-4 mb-6">
    <div class="stat-card"><div class="stat-info"><h3>Total Produk</h3><div class="stat-value">156</div></div><div class="stat-icon blue"><i class="bi bi-box-seam"></i></div></div>
    <div class="stat-card"><div class="stat-info"><h3>Stok Tersedia</h3><div class="stat-value">149</div></div><div class="stat-icon green"><i class="bi bi-check-circle"></i></div></div>
    <div class="stat-card"><div class="stat-info"><h3>Stok Menipis</h3><div class="stat-value">7</div></div><div class="stat-icon orange"><i class="bi bi-exclamation-triangle"></i></div></div>
    <div class="stat-card"><div class="stat-info"><h3>Stok Habis</h3><div class="stat-value">0</div></div><div class="stat-icon red"><i class="bi bi-x-circle"></i></div></div>
</div>

<div class="card">
    <div class="card-header"><h3 class="card-title">⚠️ Produk Stok Menipis</h3></div>
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead><tr><th>Produk</th><th>Kategori</th><th>Stok Sisa</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @php $low = [['Gula 1kg','Kebutuhan',8],['Telur 1kg','Kebutuhan',5],['Roti Sari Roti','Makanan',3],['Oreo 133g','Snack',7],['Gudang Garam 12','Rokok',6],['Sprite 390ml','Minuman',9],['Sampoerna Mild 16','Rokok',10]]; @endphp
                @foreach($low as $p)
                <tr>
                    <td><strong>{{ $p[0] }}</strong></td>
                    <td><span class="badge badge-info">{{ $p[1] }}</span></td>
                    <td><strong class="text-danger">{{ $p[2] }}</strong></td>
                    <td><span class="badge badge-danger"><i class="bi bi-exclamation-triangle"></i> Menipis</span></td>
                    <td><button class="btn btn-sm btn-primary"><i class="bi bi-plus-circle"></i> Restock</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
