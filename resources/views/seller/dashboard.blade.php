@extends('layout.seller')

@section('page-title', 'Dashboard')

@section('content')
{{-- Welcome Section --}}
<div class="mb-4">
    <h2 class="fw-bold" style="color: var(--nykaa-dark);">Welcome back, {{ Auth::guard('seller')->user()->business_name }} 👋</h2>
    <p style="color: var(--nykaa-text-light);">Here's what's happening with your store today.</p>
</div>

{{-- Approval Status Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value">{{ $pendingProducts }}</div>
            <div class="stat-label">Pending Approval</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value">{{ $approvedProducts }}</div>
            <div class="stat-label">Approved</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-value">{{ $rejectedProducts }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card info">
            <div class="stat-icon"><i class="fas fa-redo"></i></div>
            <div class="stat-value">{{ $resubmittedProducts }}</div>
            <div class="stat-label">Resubmitted</div>
        </div>
    </div>
</div>

{{-- Stats Row 2 --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card pink">
            <div class="stat-icon"><i class="fas fa-box"></i></div>
            <div class="stat-value">{{ $totalProducts }}</div>
            <div class="stat-label">Total Products</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value">{{ $pendingOrders }}</div>
            <div class="stat-label">Pending Orders</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
            <div class="stat-value">{{ $completedOrders }}</div>
            <div class="stat-label">Completed Orders</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card info">
            <div class="stat-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-value">{{ $cartActivity }}</div>
            <div class="stat-label">Cart Activity</div>
        </div>
    </div>
</div>

{{-- Revenue + Wishlist + Popular Product --}}
<div class="row g-4 mb-4">
    {{-- Revenue Card --}}
    <div class="col-md-4">
        <div class="seller-card h-100 p-4">
            <div class="d-flex align-items-center gap-3 mb-3">
                <div class="stat-icon" style="width:44px;height:44px;border-radius:10px;background:var(--nykaa-pink-light);color:var(--nykaa-pink);display:flex;align-items:center;justify-content:center;font-size:20px;">
                    <i class="fas fa-rupee-sign"></i>
                </div>
                <h6 class="fw-bold mb-0" style="color:var(--nykaa-dark);">Revenue</h6>
            </div>
            <div class="mb-2">
                <span class="d-block text-muted small">Today</span>
                <h4 class="fw-bold mb-0">₹{{ number_format($todaysRevenue, 2) }}</h4>
            </div>
            <div>
                <span class="d-block text-muted small">This Month</span>
                <h4 class="fw-bold mb-0">₹{{ number_format($monthlyRevenue, 2) }}</h4>
            </div>
        </div>
    </div>

    {{-- Wishlist Activity --}}
    <div class="col-md-4">
        <div class="stat-card info h-100">
            <div class="stat-icon"><i class="fas fa-heart"></i></div>
            <div class="stat-value">{{ $wishlistActivity }}</div>
            <div class="stat-label">Wishlist Activity</div>
        </div>
    </div>

    {{-- Most Popular Product --}}
    <div class="col-md-4">
        <div class="seller-card h-100 p-4">
            <h6 class="fw-bold mb-3" style="color:var(--nykaa-dark);">⭐ Most Popular Product</h6>
            @if($mostPopularProduct)
                <div class="d-flex align-items-center">
                    <img src="{{ asset('uploads/'.$mostPopularProduct->image) }}" alt="" style="width: 52px; height: 52px; object-fit: cover; border-radius: 10px;" class="me-3">
                    <div>
                        <h6 class="mb-1" style="color:var(--nykaa-dark);">{{ $mostPopularProduct->title }}</h6>
                        <span class="badge-nykaa bg-approved">
                            <i class="fas fa-shopping-cart me-1"></i>
                            {{ $mostPopularProduct->cart_users_count }} Cart Users
                        </span>
                    </div>
                </div>
            @else
                <p class="text-muted mb-0">No data available.</p>
            @endif
        </div>
    </div>
</div>

{{-- Quick Actions + Store Status --}}
<div class="row g-4">
    <div class="col-md-6">
        <div class="seller-card p-4">
            <h5 class="fw-bold mb-3" style="color:var(--nykaa-dark);">Quick Actions</h5>
            <div class="d-grid gap-2">
                <a href="{{ route('seller.products.create') }}" class="btn-nykaa text-center text-decoration-none">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
                <a href="{{ route('seller.orders.index') }}" class="btn-nykaa-outline text-center text-decoration-none mt-2">
                    <i class="fas fa-truck me-2"></i>View All Orders
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="seller-card p-4">
            <h5 class="fw-bold mb-3" style="color:var(--nykaa-dark);">Store Status</h5>
            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                <span style="color:var(--nykaa-text);">Approval Status</span>
                <span class="badge-nykaa bg-approved">
                    <i class="fas fa-check-circle me-1"></i>Approved
                </span>
            </div>
            <div class="d-flex justify-content-between align-items-center py-2">
                <span style="color:var(--nykaa-text);">Joined Date</span>
                <span class="text-muted">{{ Auth::guard('seller')->user()->created_at->format('M d, Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection