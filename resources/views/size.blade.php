@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row align-items-start">

        <!-- LEFT SIDE: Add Size -->
        <div class="col-lg-4 col-md-12 mb-4">

            <div class="card">

                <div class="card-header">
                    <h4>Add Size</h4>
                </div>

                <form action="{{ route('size.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label>Size Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Enter Size Name (e.g. 50 ml, 3.5 gm, 100 ml)"
                                   required>
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
                            Save Size
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- RIGHT SIDE: Size List -->
        <div class="col-lg-8 col-md-12">

            <div class="card">

                <div class="card-header">
                    <h4>Size List</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($sizes as $size)
                            <tr>
                                <td>{{ $size->id }}</td>
                                <td>{{ $size->name }}</td>
                                <td>
                                    @if($size->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-warning btn-sm editBtn"
                                            data-id="{{ $size->id }}"
                                            data-name="{{ $size->name }}"
                                            data-status="{{ $size->status }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('size.destroy', $size->id) }}"
                                          method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete Size?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Sizes Found</td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Size Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Status</label>
                        <select name="status" id="editStatus" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Size</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".editBtn");
    const modal = document.getElementById("editModal");

    editButtons.forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("editName").value = this.dataset.name;
            document.getElementById("editStatus").value = this.dataset.status;
            document.getElementById("editForm").action = "/size/update/" + this.dataset.id;

            new bootstrap.Modal(modal).show();
        });
    });
});
</script>

@endsection
