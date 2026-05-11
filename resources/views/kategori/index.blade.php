@extends('layouts.app')
@section('title', 'Kategori')
@section('page-title', 'Master Data Kategori')
@section('page-subtitle', 'Kelola kategori produk')

@section('content')
<div class="flex-between mb-6">
    <div></div>
    <button class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Kategori</button>
</div>

<div class="grid grid-3">
    @php $cats = [['Makanan','🍜',45,'#6C5CE7'],['Minuman','🥤',32,'#00CEC9'],['Snack','🍿',28,'#FDCB6E'],['Rokok','🚬',15,'#E17055'],['Kebutuhan','🧴',38,'#74B9FF']]; @endphp
    @foreach($cats as $c)
    <div class="card" style="border-top: 3px solid {{ $c[3] }}">
        <div class="card-body" style="text-align:center;padding:2rem">
            <span style="font-size:3rem">{{ $c[1] }}</span>
            <h3 style="margin:0.5rem 0;font-size:1.1rem">{{ $c[0] }}</h3>
            <p class="text-muted" style="font-size:0.8rem">{{ $c[2] }} produk</p>
            <div class="flex gap-2" style="justify-content:center;margin-top:1rem">
                <button class="btn btn-sm btn-outline"><i class="bi bi-pencil"></i> Edit</button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
