@extends('layouts.app')

@section('title', 'Kasir')
@section('page-title', 'Kasir / POS')
@section('page-subtitle', 'Buat transaksi penjualan baru')

@section('content')
<div class="pos-container">
    {{-- Left: Product Grid --}}
    <div class="pos-products">
        <div class="pos-toolbar">
            <div class="pos-search">
                <i class="bi bi-search"></i>
                <input type="text" id="productSearch" placeholder="Cari produk atau scan barcode...">
            </div>
            <div class="pos-categories" id="categoryFilter">
                <button class="cat-btn active" data-cat="all">Semua</button>
                @foreach(\App\Models\Category::all() as $cat)
                <button class="cat-btn" data-cat="{{ strtolower($cat->name) }}">{{ $cat->name }}</button>
                @endforeach
            </div>
        </div>
        <div class="product-grid" id="productGrid">
            {{-- Products will be rendered by JS --}}
        </div>
    </div>

    @push('scripts')
    <script>
        // Inject data dari database ke JS
        const products = @json(\App\Models\Product::with('category')->get()->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'price' => (int)$p->price,
                'stock' => (int)$p->stock,
                'category' => strtolower($p->category->name),
                'emoji' => '📦' // Default emoji
            ];
        }));
    </script>
    @endpush

    {{-- Right: Cart --}}
    <div class="pos-cart">
        <div class="cart-header">
            <h3><i class="bi bi-cart3"></i> Keranjang</h3>
            <button class="btn btn-sm btn-outline" id="clearCart" title="Kosongkan">
                <i class="bi bi-trash3"></i> Hapus
            </button>
        </div>

        <div class="cart-items" id="cartItems">
            <div class="cart-empty" id="cartEmpty">
                <i class="bi bi-cart-x"></i>
                <p>Keranjang kosong</p>
                <span>Klik produk untuk menambahkan</span>
            </div>
        </div>

        <div class="cart-summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal">Rp 0</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="grandTotal">Rp 0</span>
            </div>
            <div class="payment-input">
                <label>Bayar (Rp)</label>
                <input type="number" id="paymentAmount" placeholder="0" min="0">
            </div>
            <div class="summary-row change">
                <span>Kembalian</span>
                <span id="changeAmount">Rp 0</span>
            </div>
            <button class="btn btn-primary btn-lg btn-checkout" id="checkoutBtn" disabled>
                <i class="bi bi-check2-circle"></i> Bayar Sekarang
            </button>
        </div>
    </div>
</div>

{{-- Checkout Success Modal --}}
<div class="modal-overlay" id="successModal">
    <div class="modal-box">
        <div class="modal-icon success">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <h2>Transaksi Berhasil!</h2>
        <p id="modalInfo">Total: Rp 0 | Bayar: Rp 0 | Kembali: Rp 0</p>
        <div class="modal-actions">
            <button class="btn btn-outline" id="printReceipt"><i class="bi bi-printer"></i> Cetak Struk</button>
            <button class="btn btn-primary" id="newTransaction"><i class="bi bi-plus-circle"></i> Transaksi Baru</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/kasir.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/kasir.js') }}"></script>
@endpush
