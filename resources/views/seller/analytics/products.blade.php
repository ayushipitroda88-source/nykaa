@extends('layout.seller')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold">Product Analytics</h2>
        <p class="text-muted">Analyze customer interest in your products.</p>
    </div>
</div>

<!-- Filters -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('seller.analytics.products') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search Product</label>
                <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by title...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Activity From</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Activity To</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card shadow-sm border-0">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle">
           <thead class="table-light">
            <tr>
                <th>Product</th>
                <th>Brand</th>
                <th class="text-center">Cart Users</th>
                <th class="text-center">Wishlist Users</th>
            </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('uploads/'.$product->image) }}" alt="{{ $product->title }}" style="width:50px; height:50px; object-fit:cover; border-radius:4px;" class="me-3">
                                <span>{{ $product->title }}</span>
                            </div>
                        </td>
                        <td>{{ $product->brand->name ?? '-' }}</td>
                        <td class="text-center"><span class="badge bg-primary fs-6">{{ $product->cart_users_count ?? 0 }}</span></td>
                        <td class="text-center"><span class="badge bg-info text-dark fs-6">{{ $product->wishlist_users_count ?? 0 }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">No Product Analytics Found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
