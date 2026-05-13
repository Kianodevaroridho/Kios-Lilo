<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Perlengkapan Baso')) - POS System</title>
    <meta name="description" content="Perlengkapan Baso - Aplikasi Point of Sale modern untuk manajemen toko">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- App Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <div class="app-container">
        {{-- Sidebar --}}
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="logo-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Perlengkapan Baso</h1>
                        <span>POS System</span>
                    </div>
                </div>
                <button class="sidebar-close" id="sidebarClose">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">
                    <span class="nav-section-title">Menu Utama</span>
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" id="nav-dashboard">
                        <i class="bi bi-grid-1x2-fill"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ url('/kasir') }}" class="nav-link {{ request()->is('kasir') ? 'active' : '' }}" id="nav-kasir">
                        <i class="bi bi-cart3"></i>
                        <span>Kasir / POS</span>
                        <span class="nav-badge">New</span>
                    </a>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">Master Data</span>
                    <a href="{{ url('/produk') }}" class="nav-link {{ request()->is('produk*') ? 'active' : '' }}" id="nav-produk">
                        <i class="bi bi-box-seam-fill"></i>
                        <span>Produk</span>
                    </a>
                    <a href="{{ url('/kategori') }}" class="nav-link {{ request()->is('kategori*') ? 'active' : '' }}" id="nav-kategori">
                        <i class="bi bi-tags-fill"></i>
                        <span>Kategori</span>
                    </a>
                    <a href="{{ url('/stok') }}" class="nav-link {{ request()->is('stok*') ? 'active' : '' }}" id="nav-stok">
                        <i class="bi bi-archive-fill"></i>
                        <span>Stok</span>
                    </a>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">Laporan</span>
                    <a href="{{ url('/laporan/harian') }}" class="nav-link {{ request()->is('laporan/harian') ? 'active' : '' }}" id="nav-lap-harian">
                        <i class="bi bi-calendar-day-fill"></i>
                        <span>Harian</span>
                    </a>
                    <a href="{{ url('/laporan/bulanan') }}" class="nav-link {{ request()->is('laporan/bulanan') ? 'active' : '' }}" id="nav-lap-bulanan">
                        <i class="bi bi-calendar-month-fill"></i>
                        <span>Bulanan</span>
                    </a>
                    <a href="{{ url('/transaksi') }}" class="nav-link {{ request()->is('transaksi*') ? 'active' : '' }}" id="nav-transaksi">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                </div>

                <div class="nav-section">
                    <span class="nav-section-title">Pengaturan</span>
                    <a href="{{ url('/profil') }}" class="nav-link {{ request()->is('profil') ? 'active' : '' }}" id="nav-profil">
                        <i class="bi bi-person-fill"></i>
                        <span>Profil</span>
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                        <span class="user-role">{{ Auth::user()->role ?? 'Administrator' }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ url('/logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <main class="main-content">
            {{-- Top Header --}}
            <header class="top-header">
                <div class="header-left">
                    <button class="menu-toggle" id="menuToggle">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="breadcrumb-area">
                        <h2 class="page-title">@yield('page-title', 'Dashboard')</h2>
                        <p class="page-subtitle">@yield('page-subtitle', 'Selamat datang di Perlengkapan Baso POS')</p>
                    </div>
                </div>
                <div class="header-right">
                    <div class="header-search">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Cari produk, transaksi..." id="globalSearch">
                    </div>
                    <button class="header-icon-btn" id="notifBtn" title="Notifikasi">
                        <i class="bi bi-bell"></i>
                        <span class="notif-dot"></span>
                    </button>
                    <div class="header-date">
                        <i class="bi bi-calendar3"></i>
                        <span id="currentDate"></span>
                    </div>
                </div>
            </header>

            {{-- Alert Messages --}}
            @if(session('success'))
                <div class="alert alert-success" id="alertSuccess">
                    <i class="bi bi-check-circle-fill"></i>
                    <span>{{ session('success') }}</span>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error" id="alertError">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span>{{ session('error') }}</span>
                    <button class="alert-close" onclick="this.parentElement.remove()">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            {{-- Page Content --}}
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Overlay for mobile sidebar --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- App Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
