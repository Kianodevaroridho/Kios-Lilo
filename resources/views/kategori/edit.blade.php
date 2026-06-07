@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Ubah data kategori')

@section('content')
<div style="max-width:600px">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Edit Kategori</h3>
            <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-outline"><i class="bi bi-arrow-left"></i> Kembali</a>
        </div>
        <div class="card-body">
            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="name">Nama Kategori <span style="color:var(--danger)">*</span></label>
                    <input type="text" id="name" name="name" class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                           value="{{ old('name', $kategori->name) }}" required>
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="description">Deskripsi</label>
                    <textarea id="description" name="description" class="form-input" rows="3">{{ old('description', $kategori->description) }}</textarea>
                    @error('description')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-3" style="margin-top:1.5rem">
                    <a href="{{ route('kategori.index') }}" class="btn btn-outline" style="flex:1">Batal</a>
                    <button type="submit" class="btn btn-primary" style="flex:1"><i class="bi bi-check-circle"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
