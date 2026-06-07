@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')
@section('page-subtitle', 'Buat kategori produk baru')

@section('content')
<div style="max-width:600px">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Tambah Kategori</h3>
            <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">Nama Kategori <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="name" name="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                           value="{{ old('name') }}" placeholder="Contoh: Bahan Baku, Topping, Bumbu..." required>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-input" rows="3"
                              placeholder="Deskripsi singkat kategori...">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-3" style="margin-top:1.5rem">
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline" style="flex:1">Batal</a>
                    <button type="submit" class="btn btn-primary" style="flex:1"><i class="bi bi-check-circle"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
