@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-10">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        {{ $image->title }}
                    </h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 text-center">

                            <img src="{{ asset('uploads/'.$image->image) }}"
                                 class="img-fluid rounded"
                                 alt="{{ $image->title }}"
                                 style="max-height:500px;">

                        </div>

                        <div class="col-md-6">

                            <h3 class="mb-4">
                                {{ $image->title }}
                            </h3>

                            <p class="text-muted">
                                {{ $image->description }}
                            </p>

                            <div class="mt-4">

                                <a href="{{ url('/images') }}"
                                   class="btn btn-secondary">
                                    Back to Gallery
                                </a>

                                <a href="{{ url('/images/'.$image->id.'/edit') }}"
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