@extends('layout.admin')

@section('content')
<div class="container-fluid mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">📦 Seller Products - {{ $seller->business_name }}</h3>
            <p class="text-muted mb-0">
                <i class="fas fa-store me-1"></i> {{ $seller->owner_name }} 
                <span class="mx-2">|</span>
                <i class="fas fa-envelope me-1"></i> {{ $seller->email }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Sellers
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.sellers.products', $seller->id) }}" class="row g-2 align-items-center">
                <div class="col-md-4 col-lg-3">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('admin.sellers.products', $seller->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Status Tabs --}}
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a href="{{ route('admin.sellers.products', [$seller->id, 'status' => 'all']) }}" 
               class="nav-link {{ $currentStatus == 'all' ? 'active' : '' }}">
                All <span class="badge bg-secondary ms-1">{{ $statusCounts['all'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.sellers.products', [$seller->id, 'status' => 'pending']) }}" 
               class="nav-link {{ $currentStatus == 'pending' ? 'active' : '' }}">
                Pending <span class="badge bg-warning text-dark ms-1">{{ $statusCounts['pending'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.sellers.products', [$seller->id, 'status' => 'resubmitted']) }}" 
               class="nav-link {{ $currentStatus == 'resubmitted' ? 'active' : '' }}">
                Resubmitted <span class="badge bg-info text-dark ms-1">{{ $statusCounts['resubmitted'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.sellers.products', [$seller->id, 'status' => 'approved']) }}" 
               class="nav-link {{ $currentStatus == 'approved' ? 'active' : '' }}">
                Approved <span class="badge bg-success ms-1">{{ $statusCounts['approved'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.sellers.products', [$seller->id, 'status' => 'rejected']) }}" 
               class="nav-link {{ $currentStatus == 'rejected' ? 'active' : '' }}">
                Rejected <span class="badge bg-danger ms-1">{{ $statusCounts['rejected'] }}</span>
            </a>
        </li>
    </ul>

    {{-- Products Table --}}
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('uploads/' . $product->image) }}"
                                         alt="{{ $product->title }}"
                                         width="60" height="60"
                                         style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted"><i class="fas fa-image fa-2x"></i></span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->title }}</strong>
                                <br>
                                <small class="text-muted">ID: #{{ $product->id }}</small>
                            </td>
                            <td>{{ optional($product->brand)->name ?? 'N/A' }}</td>
                            <td>{{ optional($product->category)->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($product->price, 2) }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-warning text-dark',
                                        'resubmitted' => 'bg-info text-dark',
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                    ];
                                    $color = $statusColors[$product->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $color }}">{{ ucfirst($product->status) }}</span>
                                @if($product->status == 'rejected' && $product->rejection_reason)
                                    <br>
                                    <small class="text-danger" data-bs-toggle="tooltip" title="{{ $product->rejection_reason }}">
                                        <i class="fas fa-info-circle"></i> Reason
                                    </small>
                                @endif
                            </td>
                            <td>
                                <small>{{ $product->created_at->format('d M Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $product->created_at->format('h:i A') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-3x mb-3"></i>
                                    <h5>No Products Found</h5>
                                    @if(request('search'))
                                        <p>No products match your search criteria.</p>
                                    @else
                                        <p>This seller has not added any products yet.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($products->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection