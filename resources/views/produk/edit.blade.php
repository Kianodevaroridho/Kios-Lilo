@extends('layouts.app')
@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', 'Ubah data produk')

@section('content')
<div style="max-width:650px">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Produk</h3>
            <a href="{{ route('produk.index') }}" class="btn btn-sm btn-outline"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nama Produk <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="name" name="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                           value="{{ old('name', $produk->name) }}" required>
                    @error('name')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="category_id">Kategori <span style="color:var(--danger)">*</span></label>
                    <select id="category_id" name="category_id" class="form-input {{ $errors->has('category_id') ? 'error' : '' }}" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $produk->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('category_id')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="grid" style="grid-template-columns:1fr 1fr;gap:1rem">
                    <div class="form-group">
                        <label class="form-label" for="price">Harga (Rp) <span style="color:var(--danger)">*</span></label>
                        <input type="number" id="price" name="price" class="form-input {{ $errors->has('price') ? 'error' : '' }}"
                               value="{{ old('price', $produk->price) }}" min="0" required>
                        @error('price')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="stock">Stok <span style="color:var(--danger)">*</span></label>
                        <input type="number" id="stock" name="stock" class="form-input {{ $errors->has('stock') ? 'error' : '' }}"
                               value="{{ old('stock', $produk->stock) }}" min="0" required>
                        @error('stock')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="barcode">Barcode</label>
                    <input type="text" id="barcode" name="barcode" class="form-input {{ $errors->has('barcode') ? 'error' : '' }}"
                           value="{{ old('barcode', $produk->barcode) }}" placeholder="Opsional">
                    @error('barcode')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="image">Foto Produk</label>
                    @if($produk->image)
                        <div style="margin-bottom:0.75rem">
                            <img src="{{ asset('storage/' . $produk->image) }}" alt="{{ $produk->name }}"
                                 style="width:100px;height:100px;object-fit:cover;border-radius:var(--radius-md)">
                            <small class="text-muted" style="display:block;margin-top:0.25rem;font-size:0.8rem">Foto saat ini</small>
                        </div>
                    @endif
                    <input type="file" id="image" name="image" class="form-input {{ $errors->has('image') ? 'error' : '' }}"
                           accept="image/jpeg,image/png,image/jpg,image/gif">
                    <small class="text-muted" style="font-size:0.8rem">Biarkan kosong jika tidak ingin mengubah foto. Format: JPEG, PNG, JPG, GIF. Maks: 2MB</small>
                    @error('image')<span class="form-error">{{ $message }}</span>@enderror
                </div>

                <div class="flex gap-3" style="margin-top:1.5rem">
                    <a href="{{ route('produk.index') }}" class="btn btn-outline" style="flex:1">Batal</a>
                    <button type="submit" class="btn btn-primary" style="flex:1">
                        <i class="bi bi-check-circle"></i> Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
