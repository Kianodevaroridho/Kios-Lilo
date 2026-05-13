@extends('layouts.app')
@section('title', 'Produk')
@section('page-title', 'Master Data Produk')
@section('page-subtitle', 'Kelola semua produk yang dijual di toko')

@section('content')
<div class="flex-between mb-6">
    <form action="{{ route('produk.index') }}" method="GET" class="header-search" style="width:300px">
        <i class="bi bi-search"></i>
        <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
    </form>
    <a href="{{ route('produk.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Produk</a>
</div>

<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $i => $p)
            <tr>
                <td>{{ ($products->currentPage() - 1) * $products->perPage() + $i + 1 }}</td>
                <td><strong>{{ $p->name }}</strong><br><small class="text-gray-500">{{ $p->barcode }}</small></td>
                <td><span class="badge badge-info">{{ $p->category->name }}</span></td>
                <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                <td>{{ $p->stock }}</td>
                <td>
                    @if($p->stock <= 0)
                        <span class="badge badge-danger">Habis</span>
                    @elseif($p->stock <= 10)
                        <span class="badge badge-warning">Menipis</span>
                    @else
                        <span class="badge badge-success">Tersedia</span>
                    @endif
                </td>
                <td>
                    <div class="flex gap-2">
                        <a href="{{ route('produk.edit', $p->id) }}" class="btn btn-sm btn-outline"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data produk tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
