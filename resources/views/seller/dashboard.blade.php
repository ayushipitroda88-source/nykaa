@extends('layout.seller')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Welcome, {{ Auth::guard('seller')->user()->business_name }}</h2>
        <p class="text-muted">Here is what's happening with your store today.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Total Products -->
    <div class="col-md-4 col-lg-3">
        <div class="card shadow-sm h-100 border-0 bg-primary text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-semibold mb-2">Total Products</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $totalProducts }}</h2>
            </div>
        </div>
    </div>
    
    <!-- Pending Orders -->
    <div class="col-md-4 col-lg-3">
        <div class="card shadow-sm h-100 border-0 bg-warning text-dark">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-semibold mb-2">Pending Orders</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $pendingOrders }}</h2>
            </div>
        </div>
    </div>

    <!-- Completed Orders -->
    <div class="col-md-4 col-lg-3">
        <div class="card shadow-sm h-100 border-0 bg-success text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-semibold mb-2">Completed Orders</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $completedOrders }}</h2>
            </div>
        </div>
    </div>

    <!-- Revenue -->
    <div class="col-md-12 col-lg-3">
        <div class="card shadow-sm h-100 border-0 bg-info text-white">
            <div class="card-body">
                <h6 class="text-uppercase fw-semibold mb-2">Revenue</h6>
                <div class="mb-2">
                    <span class="d-block text-white-50 small">Today</span>
                    <h4 class="fw-bold mb-0">₹{{ number_format($todaysRevenue, 2) }}</h4>
                </div>
                <div>
                    <span class="d-block text-white-50 small">This Month</span>
                    <h4 class="fw-bold mb-0">₹{{ number_format($monthlyRevenue, 2) }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Cart Activity -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm h-100 border-0 bg-primary text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-semibold mb-2">Cart Activity</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $cartActivity }}</h2>
            </div>
        </div>
    </div>
    
    <!-- Wishlist Activity -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm h-100 border-0 bg-info text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-semibold mb-2">Wishlist Activity</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $wishlistActivity }}</h2>
            </div>
        </div>
    </div>

    <!-- Most Popular Product -->
    <div class="col-md-12 col-lg-4">
        <div class="card shadow-sm h-100 border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h6 class="fw-bold text-uppercase text-secondary">Most Popular Product</h6>
            </div>
            <div class="card-body">
                @if($mostPopularProduct)
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('uploads/'.$mostPopularProduct->image) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-3">
                        <div>
                            <h6 class="mb-1 text-dark">{{ $mostPopularProduct->title }}</h6>
                            <span class="badge bg-success">{{ $mostPopularProduct->cart_users_count }} Cart Users</span>
                        </div>
                    </div>
                @else
                    <p class="text-muted mb-0">No data available.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions or Info -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('seller.products.create') }}" class="btn btn-outline-primary text-start">
                        ➕ Add New Product
                    </a>
                    <a href="{{ route('seller.orders.index') }}" class="btn btn-outline-secondary text-start">
                        📦 View All Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold">Store Status</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Approval Status
                        <span class="badge bg-success rounded-pill">Approved</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        Joined Date
                        <span class="text-muted">{{ Auth::guard('seller')->user()->created_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
