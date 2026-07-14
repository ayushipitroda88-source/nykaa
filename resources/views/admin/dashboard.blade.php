@extends('layout.admin')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2 class="fw-bold">Super Admin Dashboard</h2>
        <p class="text-muted">Overview of platform activities.</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Total Cart Activity -->
    <div class="col-md-6 col-lg-6">
        <div class="card shadow-sm h-100 border-0 bg-primary text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-semibold mb-2">Total Cart Activity</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $totalCartActivity }}</h2>
                <small>Unique users interacting with products</small>
            </div>
        </div>
    </div>
    
    <!-- Total Wishlist Activity -->
    <div class="col-md-6 col-lg-6">
        <div class="card shadow-sm h-100 border-0 bg-info text-white">
            <div class="card-body text-center">
                <h6 class="text-uppercase fw-semibold mb-2">Total Wishlist Activity</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $totalWishlistActivity }}</h2>
                <small>Unique users saving products</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold"><i class="fas fa-star text-warning"></i> Most Added Product</h5>
            </div>
            <div class="card-body">
                @if($mostAddedProduct)
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('uploads/'.$mostAddedProduct->image) }}" alt="" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="ms-3">
                            <h6 class="mb-1">{{ $mostAddedProduct->title }}</h6>
                            <span class="badge bg-success">{{ $mostAddedProduct->cart_users_count }} Cart Users</span>
                        </div>
                    </div>
                @else
                    <p class="text-muted">No data available.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold"><i class="fas fa-tags text-primary"></i> Most Popular Brand</h5>
            </div>
            <div class="card-body">
                @if($mostPopularBrand)
                    <h5 class="mb-2">{{ $mostPopularBrand->name }}</h5>
                    <span class="badge bg-primary">{{ $mostPopularBrand->cart_users_count }} Total Cart Users</span>
                @else
                    <p class="text-muted">No data available.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="fw-bold"><i class="fas fa-user-tie text-secondary"></i> Most Active Seller</h5>
            </div>
            <div class="card-body">
                @if($mostActiveSeller)
                    <h5 class="mb-2">{{ $mostActiveSeller->business_name }}</h5>
                    <span class="badge bg-secondary">{{ $mostActiveSeller->cart_users_count }} Total Cart Users</span>
                @else
                    <p class="text-muted">No data available.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
