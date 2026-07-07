@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        {{ $product->title }}
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 text-center">

                            <img src="{{ asset('uploads/'.$product->image) }}"
                                 class="img-fluid rounded"
                                 alt="{{ $product->title }}"
                                 style="max-height:500px;">

                        </div>

                        <div class="col-md-6">

                            <h3 class="mb-4">
                                {{ $product->title }}
                            </h3>

                            <p class="text-muted">
                                {{ $product->description }}
                            </p>

                            <p class="h4 text-primary mb-4">
                                ₹{{ number_format($product->price, 2) }}
                            </p>

                            <div class="mt-4">

                                <a href="{{ url('/products') }}"
                                   class="btn btn-secondary">
                                    Back to Gallery
                                </a>

                                <a href="{{ url('/products/'.$product->id.'/edit') }}"
                                   class="btn btn-warning">
                                    Edit
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection