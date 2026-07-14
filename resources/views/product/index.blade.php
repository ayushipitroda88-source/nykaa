@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Products</h3>

        <a href="/upload-product" class="btn btn-primary">
            Add Product
        </a>
    </div>

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">
               <thead class="table-dark">
<tr>
    <th>ID</th>
    <th>Image</th>
    <th>Title</th>
    <th>Brand</th>
    <th>Colors</th>
    <th>Sizes</th>
    <th>Description</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Category</th>
    <th>Collection</th>
    <th>Actions</th>
</tr>
</thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>
                            <td class="align-middle">{{ $loop->iteration }}</td>

                            <td class="align-middle">
                                <a href="{{ route('product.show', $product->id) }}">
                                    <img src="{{ asset('uploads/'.$product->image) }}"
                                         alt="{{ $product->title }}"
                                         style="width:64px; height:64px; object-fit:cover; border-radius:6px;">
                                </a>
                            </td>

                            <td class="align-middle">{{ $product->title }}</td>

                            <td class="align-middle">{{ $product->brand->name ?? '-' }}</td>

                            <td class="align-middle">
                                @forelse($product->colors as $color)
                                    <span class="badge me-1" style="background-color: {{ $color->color_code }}; color: #fff; border: 1px solid #ccc; text-shadow: 0 1px 2px rgba(0,0,0,0.6);" title="{{ $color->color_code }}">
                                        {{ $color->name }}
                                    </span>
                                @empty
                                    -
                                @endforelse
                            </td>

                            <td class="align-middle">
                                @forelse($product->sizes as $size)
                                    <span class="badge bg-info text-dark me-1">{{ $size->name }}</span>
                                @empty
                                    -
                                @endforelse
                            </td>

                            <td class="align-middle text-truncate" style="max-width:200px;">
                                {{ Str::limit($product->description, 50) }}
                            </td>

                            <td class="align-middle">₹{{ number_format($product->price, 2) }}</td>

                            <td class="align-middle">{{ $product->quantity }}</td>

                            <td class="align-middle">{{ $product->category->name ?? '-' }}</td>

                            <td class="align-middle">
                                @forelse($product->collections as $collection)
                                    <span class="badge bg-secondary me-1">{{ $collection->name }}</span>
                                @empty
                                    -
                                @endforelse
                            </td>

                            <td class="align-middle" style="white-space: nowrap;">
                                <a href="{{ url('/products/'.$product->id) }}" class="btn btn-info btn-sm text-white">
                                    View
                                </a>

                                <a href="{{ url('/products/'.$product->id.'/edit') }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <a href="{{ route('variants.index',$product->id) }}"
   class="btn btn-success btn-sm">
    Variants
</a>

                                <a href="{{ url('/products/'.$product->id.'/delete') }}"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Delete this product?')">
                                    Delete
                                </a>
                            </td>
                        </tr>

                    @empty

                        <tr>
                           <td colspan="12" class="text-center">
    No Products Found
</td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection