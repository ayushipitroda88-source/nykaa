@extends('layout.seller')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Variants for: {{ $product->title }}</h3>
    <div>
        <a href="{{ route('seller.products.index') }}" class="btn btn-secondary me-2">Back to Products</a>
        <button type="button" id="addRow" class="btn btn-primary">➕ Add Row</button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white pb-0 pt-4">
        <h5 class="fw-bold">Existing Variants</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($variants as $variant)
                    <tr>
                        <td><img src="{{ asset('uploads/variants/'.$variant->image) }}" width="50" class="rounded"></td>
                        <td>{{ $variant->color->name }}</td>
                        <td>{{ $variant->size->name }}</td>
                        <td>₹{{ number_format($variant->price, 2) }}</td>
                        <td>{{ $variant->quantity }}</td>
                        <td>
                            <form action="{{ route('seller.variants.delete', $variant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this Variant?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4">No Variants Found</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white pb-0 pt-4">
        <h5 class="fw-bold">Add New Variants</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('seller.variants.store', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th width="100">Action</th>
                        </tr>
                    </thead>
                    <tbody id="variantTable">
                        <!-- JS will append rows here -->
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-success">Save All Variants</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('addRow').addEventListener('click', function () {
    const tableBody = document.getElementById('variantTable');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td><input type="file" name="image[]" class="form-control" required></td>
        <td>
            <select name="color_id[]" class="form-select" required>
                <option value="">Select Color</option>
                @foreach($colors as $color)
                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <select name="size_id[]" class="form-select" required>
                <option value="">Select Size</option>
                @foreach($sizes as $size)
                    <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" step="0.01" name="price[]" class="form-control" required></td>
        <td><input type="number" name="quantity[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
    `;
    tableBody.appendChild(newRow);
});

document.getElementById('variantTable').addEventListener('click', function(e){
    if(e.target.classList.contains('removeRow')){
        e.target.closest('tr').remove();
    }
});
</script>
@endsection
