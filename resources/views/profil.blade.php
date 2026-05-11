@extends('layouts.app')
@section('title', 'Profil')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun kamu')

@section('content')
<div class="grid grid-2">
    <div class="card">
        <div class="card-header"><h3 class="card-title"><i class="bi bi-person"></i> Informasi Akun</h3></div>
        <div class="card-body">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-input" value="Admin Kios Lilo">
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" value="admin@kioslilo.com">
            </div>
            <div class="form-group">
                <label class="form-label">Role</label>
                <input type="text" class="form-input" value="Administrator" disabled>
            </div>
            <button class="btn btn-primary"><i class="bi bi-check-lg"></i> Simpan Perubahan</button>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h3 class="card-title"><i class="bi bi-shield-lock"></i> Ubah Password</h3></div>
        <div class="card-body">
            <div class="form-group">
                <label class="form-label">Password Lama</label>
                <input type="password" class="form-input" placeholder="Masukkan password lama">
            </div>
            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" class="form-input" placeholder="Masukkan password baru">
            </div>
            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-input" placeholder="Ulangi password baru">
            </div>
            <button class="btn btn-primary"><i class="bi bi-lock"></i> Update Password</button>
        </div>
    </div>
</div>
@endsection
