@extends('layout.seller')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">My Products</h3>
    <div>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">➕ Add New Product</a>
    </div>
</div>

{{-- Status Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="card-body text-center py-3">
                <h6 class="text-uppercase fw-semibold text-warning mb-1">Pending</h6>
                <h3 class="fw-bold mb-0">{{ $products->where('status', 'pending')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm bg-success bg-opacity-10">
            <div class="card-body text-center py-3">
                <h6 class="text-uppercase fw-semibold text-success mb-1">Approved</h6>
                <h3 class="fw-bold mb-0">{{ $products->where('status', 'approved')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
            <div class="card-body text-center py-3">
                <h6 class="text-uppercase fw-semibold text-danger mb-1">Rejected</h6>
                <h3 class="fw-bold mb-0">{{ $products->where('status', 'rejected')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm bg-info bg-opacity-10">
            <div class="card-body text-center py-3">
                <h6 class="text-uppercase fw-semibold text-info mb-1">Resubmitted</h6>
                <h3 class="fw-bold mb-0">{{ $products->where('status', 'resubmitted')->count() }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Products Table --}}
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        {{-- Title --}}
                        <td>
                            <strong>{{ $product->title }}</strong>
                            @if($product->status == 'rejected' && $product->rejection_reason)
                                <br>
                                <span class="text-danger small">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <strong>Reason:</strong> {{ $product->rejection_reason }}
                                </span>
                            @endif
                        </td>

                        {{-- Category --}}
                        <td>{{ $product->category->name ?? 'N/A' }}</td>

                        {{-- Brand --}}
                        <td>{{ $product->brand->name ?? 'N/A' }}</td>

                        {{-- Status Badge --}}
                        <td>
                            @php
                                $badgeColors = [
                                    'pending' => 'bg-warning text-dark',
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    'resubmitted' => 'bg-info text-dark',
                                ];
                                $badgeColor = $badgeColors[$product->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $badgeColor }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>

                        {{-- Created Date --}}
                        <td>
                            <small class="text-muted">{{ $product->created_at->format('d M Y') }}</small>
                        </td>

                        {{-- Actions --}}
                        <td>
                            <div class="d-flex gap-2 flex-wrap">

                                {{-- Variant Edit --}}
                                <a href="{{ route('seller.variants.index', $product->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Manage Variants">
                                    <i class="fas fa-layer-group me-1"></i>Manage Variants
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('seller.products.destroy', $product->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">No products found. Start by adding one!</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection