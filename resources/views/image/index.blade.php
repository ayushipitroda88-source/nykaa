@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Image Gallery</h3>

            <a href="/upload-image" class="btn btn-primary">
            Add Image
        </a>
    </div>

    <div class="row">

        @foreach($images as $img)

            <div class="col-md-4 mb-4">

                <div class="card shadow-sm">

                    <img src="{{ asset('uploads/'.$img->image) }}"
                         class="card-img-top"
                         style="height:300px; object-fit:cover;"
                         alt="{{ $img->title }}">

                    <div class="card-body text-center">

                        <h5 class="card-title">
                            {{ $img->title }}
                        </h5>

                        <a href="{{ url('/images/'.$img->id) }}"
                           class="btn btn-info btn-sm">
                            View
                        </a>

                        <a href="{{ url('/images/'.$img->id.'/edit') }}"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="{{ url('/images/'.$img->id.'/delete') }}"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Delete this image?')">
                            Delete
                        </a>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection