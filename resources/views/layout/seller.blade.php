<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nykaa Seller Center</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Seller Custom CSS -->
    <link href="{{ asset('css/seller.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

<div class="seller-wrapper">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="seller-sidebar" id="sellerSidebar">
        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="brand-icon">N</div>
            <div class="brand-text">
                Nykaa Seller
                <small>Seller Center</small>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            @if(Auth::guard('seller')->check())
                @php $isApproved = Auth::guard('seller')->user()->status === 'approved'; @endphp

                @if($isApproved)
                <div class="nav-section-title">Main Menu</div>

                <div class="nav-item">
                    <a href="{{ route('seller.dashboard') }}" class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
                        Dashboard
                    </a>
                </div>

                <div class="nav-section-title">Management</div>

                <div class="nav-item">
                    <a href="{{ route('seller.products.index') }}" class="nav-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-box"></i></span>
                        Products
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('seller.colors.index') }}" class="nav-link {{ request()->routeIs('seller.colors.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-palette"></i></span>
                        Colors
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('seller.sizes.index') }}" class="nav-link {{ request()->routeIs('seller.sizes.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-ruler"></i></span>
                        Sizes
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('seller.orders.index') }}" class="nav-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-truck"></i></span>
                        Orders
                    </a>
                </div>

                <div class="nav-item">
                    <a href="{{ route('seller.reviews.index') }}" class="nav-link {{ request()->routeIs('seller.reviews.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-star"></i></span>
                        Reviews
                    </a>
                </div>

                <div class="nav-section-title">Reports</div>

                <div class="nav-item">
                    <a href="{{ route('seller.analytics.products') }}" class="nav-link {{ request()->routeIs('seller.analytics.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-chart-bar"></i></span>
                        Analytics
                    </a>
                </div>

                <div class="nav-section-title">Support</div>

                <div class="nav-item {{ request()->routeIs('seller.request-center.*') ? 'active' : '' }}">
                    <a href="{{ route('seller.request-center.index') }}" class="nav-link {{ request()->routeIs('seller.request-center.*') ? 'active' : '' }}">
                        <span class="nav-icon"><i class="fas fa-clipboard-list"></i></span>
                        Request Center
                        @php $unreadCount = app(\App\Services\RequestCenterService::class)->getUnreadNotificationCount(Auth::guard('seller')->id()); @endphp
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-auto">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </div>
                @endif

                @if(!$isApproved)
                <div class="nav-item">
                    <a href="{{ route('seller.verification.status') }}" class="nav-link">
                        <span class="nav-icon"><i class="fas fa-shield-alt"></i></span>
                        Verification Status
                    </a>
                </div>
                @endif
            @endif
        </nav>

        {{-- Sidebar Footer --}}
        @if(Auth::guard('seller')->check())
        <div class="sidebar-footer">
            <div class="seller-info">
                @php
                    $seller = Auth::guard('seller')->user();
                    $initial = strtoupper(substr($seller->business_name, 0, 1));
                @endphp
                <div class="seller-avatar">{{ $initial }}</div>
                <div class="seller-name">
                    {{ $seller->business_name }}
                    <small>
                        <span class="seller-status">
                            <span class="status-dot {{ $seller->status }}"></span>
                            {{ ucfirst($seller->status) }}
                        </span>
                    </small>
                </div>
            </div>
        </div>
        @endif
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="seller-main">

        {{-- Top Header --}}
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <button class="sidebar-toggle" id="sidebarToggle" type="button">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">
                    @yield('page-title', 'Dashboard')
                </h1>
            </div>
            <div class="header-actions">
                @if(Auth::guard('seller')->check())
                <a href="{{ route('seller.profile.edit') }}" class="logout-btn">
                    <i class="fas fa-user-cog"></i>
                    Profile
                </a>
                <form action="{{ route('seller.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </button>
                </form>
                @endif
            </div>
        </header>

        {{-- Content Area --}}
        <div class="content-area">
            @hasSection('page-header')
                <div class="page-header-section">
                    @yield('page-header')
                </div>
            @endif

            {{-- Alerts --}}
            @if(session('success'))
                <div class="seller-alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="seller-alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

{{-- Mobile Sidebar Toggle Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sellerSidebar');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function() {
                sidebar.classList.toggle('show');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 991.98) {
                    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        }
    });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>