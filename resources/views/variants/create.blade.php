@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h3>Add Variant - {{ $product->title }}</h3>
                </div>

                <div class="card-body">

                    <form action="{{ route('variants.store',$product->id) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        {{-- Color --}}
                        <div class="mb-3">
                            <label>Color</label>

                            <select name="color_id" class="form-control" required>

                                <option value="">Select Color</option>

                                @foreach($colors as $color)

                                    <option value="{{ $color->id }}">
                                        {{ $color->name }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        {{-- Size --}}
                        <div class="mb-3">
                            <label>Size</label>

                            <select name="size_id" class="form-control" required>

                                <option value="">Select Size</option>

                                @foreach($sizes as $size)

                                    <option value="{{ $size->id }}">
                                        {{ $size->name }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        {{-- Variant Image --}}
                        <div class="mb-3">
                            <label>Variant Image</label>

                            <input type="file"
                                   name="image"
                                   class="form-control"
                                   required>
                        </div>

                        {{-- Price --}}
                        <div class="mb-3">
                            <label>Price</label>

                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   class="form-control"
                                   placeholder="Enter Price"
                                   required>
                        </div>

                        {{-- Quantity --}}
                        <div class="mb-3">
                            <label>Quantity</label>

                            <input type="number"
                                   name="quantity"
                                   class="form-control"
                                   placeholder="Enter Quantity"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-success">
                            Save Variant
                        </button>

                        <a href="{{ route('variants.index',$product->id) }}"
                           class="btn btn-secondary">
                            Back
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection