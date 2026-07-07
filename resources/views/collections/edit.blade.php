@extends('layout.admin')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            <h4>Edit Collection</h4>
        </div>

        <form action="{{ route('collections.update', $collection->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="card-body">

                <!-- Collection Name -->
                <div class="form-group mb-3">
                    <label>Collection Name</label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', $collection->name) }}"
                           class="form-control"
                           required>
                </div>

                <!-- Discount -->
                <div class="form-group mb-3">
                    <label>Discount (%)</label>

                    <input type="number"
                           name="discount"
                           value="{{ old('discount', $collection->discount) }}"
                           class="form-control"
                           min="0"
                           max="100">
                </div>

                <!-- Start Date -->
                <div class="form-group mb-3">
                    <label>Discount Start Date</label>

                    <input type="date"
                           name="discount_start"
                           value="{{ old('discount_start', $collection->discount_start) }}"
                           class="form-control">
                </div>

                <!-- End Date -->
                <div class="form-group mb-3">
                    <label>Discount End Date</label>

                    <input type="date"
                           name="discount_end"
                           value="{{ old('discount_end', $collection->discount_end) }}"
                           class="form-control">
                </div>

            </div>

            <div class="card-footer">

                <button type="submit"
                        class="btn btn-primary">
                    Update Collection
                </button>

            </div>

        </form>

    </div>

</div>

@endsection