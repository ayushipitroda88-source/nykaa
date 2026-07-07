@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Edit Product
                    </h3>
                </div>

                <div class="card-body">

                    <form action="{{ url('/images/'.$image->id.'/update') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Title
                            </label>

                            <input type="text"
                                   name="title"
                                   value="{{ $image->title }}"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Current Image
                            </label>

                            <br>

                            <img src="{{ asset('uploads/'.$image->image) }}"
                                 class="img-fluid rounded"
                                 style="max-width:200px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                New Image
                            </label>

                            <input type="file"
                                   name="image"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Description
                            </label>

                            <textarea name="description"
                                      rows="5"
                                      class="form-control">{{ $image->description }}</textarea>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            Update
                        </button>

                        <a href="{{ url('/images') }}"
                           class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection