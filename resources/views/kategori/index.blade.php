@extends('layouts.app')
@section('title', 'Kategori')
@section('page-title', 'Master Data Kategori')
@section('page-subtitle', 'Kelola kategori perlengkapan baso')

@section('content')
<div class="flex-between mb-6">
    <form action="{{ route('kategori.index') }}" method="GET" class="header-search" style="width:300px">
        <i class="bi bi-search"></i>
        <input type="text" name="search" placeholder="Cari kategori..." value="{{ request('search') }}">
    </form>
    <a href="{{ route('kategori.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Kategori</a>
</div>

@php
$iconMap = [
    'Bahan Baku'        => ['icon' => '🥩', 'color' => '#E17055'],
    'Topping & Pelengkap' => ['icon' => '🍜', 'color' => '#6C5CE7'],
    'Bumbu & Saos'      => ['icon' => '🫙', 'color' => '#FDCB6E'],
    'Minuman'           => ['icon' => '🥤', 'color' => '#00CEC9'],
    'Kemasan'           => ['icon' => '📦', 'color' => '#74B9FF'],
];
$defaultIcon  = ['icon' => '🏷️', 'color' => '#636E72'];
@endphp

<div class="grid grid-3">
    @forelse($categories as $cat)
    @php
        $meta = $iconMap[$cat->name] ?? $defaultIcon;
    @endphp
    <div class="card" style="border-top: 3px solid {{ $meta['color'] }}">
        <div class="card-body" style="text-align:center;padding:2rem">
            <span style="font-size:3rem">{{ $meta['icon'] }}</span>
            <h3 style="margin:0.5rem 0;font-size:1.1rem">{{ $cat->name }}</h3>
            @if($cat->description)
                <p class="text-muted" style="font-size:0.8rem;margin-bottom:0.25rem">{{ $cat->description }}</p>
            @endif
            <p class="text-muted" style="font-size:0.8rem">
                <strong>{{ $cat->products_count }}</strong> produk
            </p>
            <div class="flex gap-2" style="justify-content:center;margin-top:1rem">
                <a href="{{ route('kategori.edit', $cat->id) }}" class="btn btn-sm btn-outline"><i class="bi bi-pencil"></i> Edit</a>
                <form action="{{ route('kategori.destroy', $cat->id) }}" method="POST"
                      onsubmit="return confirm('Hapus kategori {{ $cat->name }}? Pastikan tidak ada produk di dalamnya.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="card" style="grid-column:1/-1">
        <div class="card-body text-center" style="padding:3rem">
            <i class="bi bi-tags" style="font-size:3rem;color:var(--gray-300)"></i>
            <p style="margin-top:1rem;color:var(--gray-500)">Belum ada kategori. Silakan tambah kategori terlebih dahulu.</p>
        </div>
    </div>
    @endforelse
</div>

<div class="pagination mt-4">
    {{ $categories->links() }}
</div>
@endsection
