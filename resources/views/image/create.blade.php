@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">
                        Upload Makeup Product
                    </h3>
                </div>

                <div class="card-body">

                    <form action="/upload-image"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Product Title
                            </label>

                            <input type="text"
                                   name="title"
                                   class="form-control"
                                   placeholder="Enter product title">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Product Image
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
                                      class="form-control"
                                      placeholder="Enter product description"></textarea>
                        </div>

                        <button type="submit"
                                class="btn btn-primary">
                            Upload Product
                        </button>

                        <a href="{{ url('/images') }}"
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