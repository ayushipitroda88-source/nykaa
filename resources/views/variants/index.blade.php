```blade
@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ $product->title }} Variants</h3>

        <button type="button"
                id="addRow"
                class="btn btn-primary">
            + Add Row
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Existing Variants -->
    <div class="card mb-4">

        <div class="card-header">
            <h5>Existing Variants</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>
                        <th>Image</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th width="150">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($variants as $variant)

                    <tr>

                        <td>{{ $variant->id }}</td>

                        <td>
                            <img src="{{ asset('uploads/variants/'.$variant->image) }}"
                                 width="70"
                                 class="rounded">
                        </td>

                        <td>{{ $variant->color->name }}</td>

                        <td>{{ $variant->size->name }}</td>

                        <td>₹{{ number_format($variant->price,2) }}</td>

                        <td>{{ $variant->quantity }}</td>

                        <td>

                            <a href="{{ route('variants.edit',$variant->id) }}"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                            <form action="{{ route('variants.delete',$variant->id) }}"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete this Variant?')">

                                    Delete

                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center">

                            No Variant Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <!-- Add New Variants -->

    <div class="card">

        <div class="card-header">
            <h5>Add New Variants</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('variants.store',$product->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

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

                <div class="mt-3">

                    <button type="submit"
                            class="btn btn-success">

                        Save All Variants

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

document.getElementById('addRow').addEventListener('click', function () {

    const tableBody = document.getElementById('variantTable');

    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td>
            <input type="file" name="image[]" class="form-control" required>
        </td>

        <td>
            <select name="color_id[]" class="form-control" required>

                <option value="">Select Color</option>

                @foreach($colors as $color)
                    <option value="{{ $color->id }}">
                        {{ $color->name }}
                    </option>
                @endforeach

            </select>
        </td>

        <td>
            <select name="size_id[]" class="form-control" required>

                <option value="">Select Size</option>

                @foreach($sizes as $size)
                    <option value="{{ $size->id }}">
                        {{ $size->name }}
                    </option>
                @endforeach

            </select>
        </td>

        <td>
            <input type="number"
                   step="0.01"
                   name="price[]"
                   class="form-control"
                   required>
        </td>

        <td>
            <input type="number"
                   name="quantity[]"
                   class="form-control"
                   required>
        </td>

        <td>
            <button type="button"
                    class="btn btn-danger btn-sm removeRow">

                Remove

            </button>
        </td>
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