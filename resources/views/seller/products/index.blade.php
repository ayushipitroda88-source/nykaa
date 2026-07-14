@extends('layout.seller')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">My Products</h3>
    <a href="{{ route('seller.products.create') }}" class="btn btn-primary">➕ Add New Product</a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
    @if($product->image)
        <img src="{{ asset('uploads/' . $product->image) }}"
             alt="{{ $product->title }}"
             width="60"
             height="60"
             style="object-fit: cover; border-radius:8px;">
    @else
        <span class="text-muted">No Image</span>
    @endif
</td>
                        <td>{{ $product->title }}</td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ $product->brand->name ?? 'N/A' }}</td>
                        <td>₹{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>
                            <span class="badge 
                                @if($product->status == 'pending') bg-warning text-dark
                                @elseif($product->status == 'approved') bg-success
                                @else bg-danger @endif">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                            <form action="{{ route('seller.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
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
