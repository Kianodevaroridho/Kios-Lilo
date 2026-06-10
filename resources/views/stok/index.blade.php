@extends('layouts.app')
@section('title', 'Stok')
@section('page-title', 'Manajemen Stok')
@section('page-subtitle', 'Pantau dan kelola stok perlengkapan baso')

@section('content')
{{-- Statistik Stok --}}
<div class="grid grid-4 mb-6">
    <div class="stat-card">
        <div class="stat-info">
            <h3>Total Produk</h3>
            <div class="stat-value">{{ $totalProduk }}</div>
        </div>
        <div class="stat-icon blue"><i class="bi bi-box-seam"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>Stok Tersedia</h3>
            <div class="stat-value">{{ $stokTersedia }}</div>
        </div>
        <div class="stat-icon green"><i class="bi bi-check-circle"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>Stok Menipis</h3>
            <div class="stat-value">{{ $stokMenipis }}</div>
        </div>
        <div class="stat-icon orange"><i class="bi bi-exclamation-triangle"></i></div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <h3>Stok Habis</h3>
            <div class="stat-value">{{ $stokHabis }}</div>
        </div>
        <div class="stat-icon red"><i class="bi bi-x-circle"></i></div>
    </div>
</div>

{{-- Peringatan Stok Menipis --}}
@if($lowStockProducts->count() > 0)
<div class="card mb-6">
    <div class="card-header">
        <h3 class="card-title">⚠️ Produk Stok Menipis</h3>
        <span class="badge badge-warning">{{ $lowStockProducts->count() }} produk</span>
    </div>
    <div class="card-body" style="padding:0">
        <table class="table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Stok Sisa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStockProducts as $p)
                <tr>
                    <td><strong>{{ $p->name }}</strong><br><small class="text-muted">{{ $p->barcode }}</small></td>
                    <td><span class="badge badge-info">{{ $p->category->name }}</span></td>
                    <td><strong class="text-danger">{{ $p->stock }}</strong></td>
                    <td><span class="badge badge-warning"><i class="bi bi-exclamation-triangle"></i> Menipis</span></td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="openRestockModal({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->stock }})">
                            <i class="bi bi-plus-circle"></i> Restock
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Semua Produk --}}
<div class="flex-between mb-4">
    <form action="{{ route('stok.index') }}" method="GET" class="header-search" style="width:300px">
        <i class="bi bi-search"></i>
        <input type="text" name="search" placeholder="Cari produk atau barcode..." value="{{ request('search') }}">
    </form>
    <div class="flex gap-2">
        <a href="{{ route('stok.index') }}" class="btn btn-sm btn-outline {{ !request('status') ? 'btn-primary' : '' }}">Semua</a>
        <a href="{{ route('stok.index', ['status' => 'low']) }}" class="btn btn-sm btn-outline {{ request('status') == 'low' ? 'btn-primary' : '' }}">
            <i class="bi bi-exclamation-triangle"></i> Menipis
        </a>
        <a href="{{ route('stok.logs') }}" class="btn btn-sm btn-outline">
            <i class="bi bi-clock-history"></i> Riwayat Stok
        </a>
    </div>
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
                <td><strong>{{ $p->name }}</strong><br><small class="text-muted">{{ $p->barcode }}</small></td>
                <td><span class="badge badge-info">{{ $p->category->name }}</span></td>
                <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                <td><strong>{{ $p->stock }}</strong></td>
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
                    <button class="btn btn-sm btn-primary" onclick="openRestockModal({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->stock }})">
                        <i class="bi bi-plus-circle"></i> Restock
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada produk ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="pagination mt-4">
    {{ $products->links() }}
</div>

{{-- Restock Modal --}}
<div id="restockModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);z-index:300;align-items:center;justify-content:center;">
    <div style="background:var(--white);border-radius:var(--radius-xl);padding:2.5rem;max-width:420px;width:90%;animation:scaleIn 0.3s ease">
        <h3 style="margin-bottom:0.25rem;font-size:1.2rem">Tambah Stok</h3>
        <p id="restockProductName" style="color:var(--gray-500);font-size:0.85rem;margin-bottom:1.5rem"></p>

        <form action="{{ route('stok.restock') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" id="restockProductId">

            <div class="form-group">
                <label class="form-label">Stok Saat Ini</label>
                <input type="text" id="restockCurrentStock" class="form-input" disabled style="background:var(--gray-100)">
            </div>

            <div class="form-group">
                <label class="form-label">Jumlah Tambah <span style="color:var(--danger)">*</span></label>
                <input type="number" name="qty" class="form-input" min="1" placeholder="Masukkan jumlah..." required>
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <input type="text" name="description" class="form-input" placeholder="Contoh: Pembelian stok mingguan">
            </div>

            <div class="flex gap-3" style="margin-top:1.5rem">
                <button type="button" onclick="closeRestockModal()" class="btn btn-outline" style="flex:1">Batal</button>
                <button type="submit" class="btn btn-primary" style="flex:1"><i class="bi bi-check-circle"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openRestockModal(id, name, stock) {
        document.getElementById('restockProductId').value = id;
        document.getElementById('restockProductName').textContent = name;
        document.getElementById('restockCurrentStock').value = stock + ' pcs';
        const modal = document.getElementById('restockModal');
        modal.style.display = 'flex';
    }

    function closeRestockModal() {
        document.getElementById('restockModal').style.display = 'none';
    }

    // Tutup modal saat klik backdrop
    document.getElementById('restockModal').addEventListener('click', function(e) {
        if (e.target === this) closeRestockModal();
    });
</script>
@endpush
