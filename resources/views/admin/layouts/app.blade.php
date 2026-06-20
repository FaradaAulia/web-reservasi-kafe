<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cafe Reservation</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/admin-styles.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<div class="container-fluid p-0">
    <div class="row g-0">
        
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 sidebar d-none d-md-block">
            <div class="brand d-flex align-items-center gap-2">
                <i class="bi bi-cup-hot-fill text-warning"></i>
                <span>CAFE RESERVASI</span>
            </div>
            
            <div class="nav flex-column mt-4">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <i class="bi bi-tags"></i>
                    <span>Kategori Menu</span>
                </a>
                <a href="{{ route('admin.menu.index') }}" class="nav-link {{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-richtext"></i>
                    <span>Menu Kafe</span>
                </a>
                <a href="{{ route('admin.meja.index') }}" class="nav-link {{ request()->routeIs('admin.meja.*') ? 'active' : '' }}">
                    <i class="bi bi-table"></i>
                    <span>Meja Kafe</span>
                </a>
                <a href="{{ route('admin.pembayaran.index') }}" class="nav-link {{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i>
                    <span>Pembayaran</span>
                </a>
                <a href="{{ route('admin.scan.index') }}" class="nav-link {{ request()->routeIs('admin.scan.index') ? 'active' : '' }}">
                    <i class="bi bi-qr-code-scan"></i>
                    <span>Scan QR</span>
                </a>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="col-md-9 col-lg-10">
            
            <!-- Top Navbar -->
            <div class="top-navbar d-flex justify-content-between align-items-center">
                <h5 class="m-0 font-weight-600">
                    @yield('header_title', 'Admin Panel')
                </h5>
                <div class="d-flex align-items-center gap-3">
                    <span class="text-muted small">Halo, <strong>{{ Auth::user()->name }}</strong></span>
                    
                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm border-0 d-flex align-items-center gap-1">
                            <i class="bi bi-box-arrow-right"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Content Area -->
            <div class="content-area">
                <!-- Session Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show card-custom p-3 mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show card-custom p-3 mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>

        </div>

    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
