@extends('layout.seller')

@section('page-title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:var(--nykaa-dark);">My Products</h4>
        <p class="text-muted mb-0">Manage your product catalog</p>
    </div>
    <div>
        <a href="{{ route('seller.products.create') }}" class="btn-nykaa text-decoration-none">
            <i class="fas fa-plus me-1"></i> Add New Product
        </a>
    </div>
</div>

{{-- Status Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="stat-card warning">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-value">{{ $products->where('status', 'pending')->count() }}</div>
            <div class="stat-label">Pending</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card success">
            <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value">{{ $products->where('status', 'approved')->count() }}</div>
            <div class="stat-label">Approved</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card danger">
            <div class="stat-icon"><i class="fas fa-times-circle"></i></div>
            <div class="stat-value">{{ $products->where('status', 'rejected')->count() }}</div>
            <div class="stat-label">Rejected</div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="stat-card info">
            <div class="stat-icon"><i class="fas fa-redo"></i></div>
            <div class="stat-value">{{ $products->where('status', 'resubmitted')->count() }}</div>
            <div class="stat-label">Resubmitted</div>
        </div>
    </div>
</div>

{{-- Products Table --}}
<div class="seller-card">
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="seller-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</  th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <strong>{{ $product->title }}</strong>
                            @if($product->status == 'rejected' && $product->rejection_reason)
                                <br>
                                <span style="color:var(--nykaa-danger);font-size:12px;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <strong>Reason:</strong> {{ $product->rejection_reason }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ $product->brand->name ?? 'N/A' }}</td>
                        <td>
                            @php
                                $badgeClass = match($product->status) {
                                    'pending' => 'bg-pending',
                                    'approved' => 'bg-approved',
                                    'rejected' => 'bg-rejected',
                                    'resubmitted' => 'bg-resubmitted',
                                    default => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge-nykaa {{ $badgeClass }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td><small class="text-muted">{{ $product->created_at->format('d M Y') }}</small></td>
                        <td>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('seller.variants.index', $product->id) }}" class="btn-action view">
                                    <i class="fas fa-layer-group"></i> Variants
                                </a>
                                <a href="{{ route('seller.request-center.create', ['product_id' => $product->id, 'type' => 'product_edit']) }}" class="btn-action edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="{{ route('seller.request-center.create', ['product_id' => $product->id, 'type' => 'product_delete']) }}" class="btn-action delete">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5" style="color:var(--nykaa-text-light);">
                            <i class="fas fa-box fa-2x mb-2 d-block"></i>
                            No products found. Start by adding one!
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection