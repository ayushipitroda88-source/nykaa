@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h3>Edit Variant</h3>
                </div>

                <div class="card-body">

                    <form action="{{ route('variants.update',$variant->id) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label>Color</label>

                            <select name="color_id" class="form-control">

                                @foreach($colors as $color)

                                    <option value="{{ $color->id }}"
                                        {{ $variant->color_id == $color->id ? 'selected' : '' }}>

                                        {{ $color->name }}

                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Size</label>

                            <select name="size_id" class="form-control">

                                @foreach($sizes as $size)

                                    <option value="{{ $size->id }}"
                                        {{ $variant->size_id == $size->id ? 'selected' : '' }}>

                                        {{ $size->name }}

                                    </option>

                                @endforeach

                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Price</label>

                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   value="{{ $variant->price }}"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label>Quantity</label>

                            <input type="number"
                                   name="quantity"
                                   value="{{ $variant->quantity }}"
                                   class="form-control">
                        </div>

                        <div class="mb-3">

                            <label>Current Image</label>

                            <br>

                            <img src="{{ asset('uploads/variants/'.$variant->image) }}"
                                 width="120">

                        </div>

                        <div class="mb-3">

                            <label>New Image</label>

                            <input type="file"
                                   name="image"
                                   class="form-control">

                        </div>

                        <button class="btn btn-success">

                            Update Variant

                        </button>

                        <a href="{{ route('variants.index',$variant->product_id) }}"
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