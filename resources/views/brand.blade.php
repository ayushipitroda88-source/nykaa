@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row align-items-start">

        <!-- LEFT SIDE -->
        <div class="col-lg-4 col-md-12 mb-4">

            <div class="card">

                <div class="card-header">
                    <h4>Add Brand</h4>
                </div>

                <form action="{{ route('brand.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label>Brand Name</label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Enter Brand Name"
                                   required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Brand Logo</label>

                            <input type="file"
                                   name="logo"
                                   class="form-control">
                        </div>

                        <div class="form-group mt-3">
                            <label>Description</label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="4"
                                placeholder="Enter Description"></textarea>
                        </div>

                        <div class="form-group mt-3">
                            <label>Status</label>

                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary">
                            Save Brand
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-lg-8 col-md-12">

            <div class="card">

                <div class="card-header">
                    <h4>Brand List</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">

                        <thead>

                        <tr>
                            <th>ID</th>
                            <th>Logo</th>
                            <th>Brand</th>
                           <th>Description</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>

                        </thead>

                        <tbody>

                        @forelse($brands as $brand)

                        <tr>

                            <td>{{ $brand->id }}</td>

                            <td>

                                @if($brand->logo)

                                    <img src="{{ asset('uploads/brands/'.$brand->logo) }}"
                                         width="60"
                                         height="60"
                                         style="object-fit:cover;border-radius:8px;">

                                @else

                                    No Image

                                @endif

                            </td>

                            <td>{{ $brand->name }}</td>

                            <td>{{ $brand->description }}</td>

                            <td>

                                @if($brand->status)

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                            <td>

                                <button
                                    type="button"
                                    class="btn btn-warning btn-sm editBtn"

                                    data-id="{{ $brand->id }}"
                                    data-name="{{ $brand->name }}"
                                    data-description="{{ $brand->description }}"
                                    data-status="{{ $brand->status }}">

                                    Edit

                                </button>

                                <form action="{{ route('brand.destroy',$brand->id) }}"
                                      method="POST"
                                      style="display:inline-block;">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete Brand?')">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No Brand Found

                            </td>

                        </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection