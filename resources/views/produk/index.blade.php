@extends('layouts.app')
@section('title', 'Produk')
@section('page-title', 'Master Data Produk')
@section('page-subtitle', 'Kelola semua produk yang dijual di toko')

@section('content')
<div class="flex-between mb-6">
    <div class="header-search" style="width:300px">
        <i class="bi bi-search"></i>
        <input type="text" placeholder="Cari produk...">
    </div>
    <button class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Produk</button>
</div>

<div class="table-container">
    <table class="table">
        <thead><tr><th>No</th><th>Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @php $items = [['Indomie Goreng','Makanan',3500,120],['Aqua 600ml','Minuman',4000,200],['Teh Botol Sosro','Minuman',5000,75],['Chitato 68g','Snack',10000,30],['Sampoerna Mild 16','Rokok',32000,20],['Telur 1kg','Kebutuhan',28000,15],['Minyak Goreng 1L','Kebutuhan',18000,25],['Gula 1kg','Kebutuhan',16000,8]]; @endphp
            @foreach($items as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td><strong>{{ $p[0] }}</strong></td>
                <td><span class="badge badge-info">{{ $p[1] }}</span></td>
                <td>Rp {{ number_format($p[2],0,',','.') }}</td>
                <td>{{ $p[3] }}</td>
                <td>{!! $p[3]<=10 ? '<span class="badge badge-danger">Menipis</span>' : '<span class="badge badge-success">Tersedia</span>' !!}</td>
                <td><div class="flex gap-2"><button class="btn btn-sm btn-outline"><i class="bi bi-pencil"></i></button><button class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button></div></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
