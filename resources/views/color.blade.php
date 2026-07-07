@extends('layout.admin')

@section('content')

<div class="container-fluid">

    <div class="row align-items-start">

        <!-- LEFT SIDE: Add Color -->
        <div class="col-lg-4 col-md-12 mb-4">

            <div class="card">

                <div class="card-header">
                    <h4>Add Color</h4>
                </div>

                <form action="{{ route('color.store') }}" method="POST">
                    @csrf

                    <div class="card-body">

                        <div class="form-group">
                            <label>Color Name</label>
                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   placeholder="Enter Color Name (e.g. Pink, Red)"
                                   required>
                        </div>

                        <div class="form-group mt-3">
                            <label>Color Hex Code</label>
                            <div class="d-flex gap-2">
                                <input type="color"
                                       id="color_picker"
                                       class="form-control form-control-color"
                                       style="width: 45px; height: 38px; padding: 2px;"
                                       value="#ff0000"
                                       oninput="document.getElementById('color_hex').value = this.value">
                                <input type="text"
                                       name="color_code"
                                       id="color_hex"
                                       class="form-control"
                                       placeholder="#ff0000"
                                       value="#ff0000"
                                       required
                                       oninput="document.getElementById('color_picker').value = this.value">
                            </div>
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
                            Save Color
                        </button>
                    </div>

                </form>

            </div>

        </div>

        <!-- RIGHT SIDE: Color List -->
        <div class="col-lg-8 col-md-12">

            <div class="card">

                <div class="card-header">
                    <h4>Color List</h4>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-hover">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Preview</th>
                                <th>Name</th>
                                <th>Hex Code</th>
                                <th>Status</th>
                                <th width="180">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($colors as $color)
                            <tr>
                                <td>{{ $color->id }}</td>
                                <td>
                                    <div style="width: 30px; height: 30px; border-radius: 50%; background-color: {{ $color->color_code }}; border: 1px solid #ccc;"></div>
                                </td>
                                <td>{{ $color->name }}</td>
                                <td><code>{{ $color->color_code }}</code></td>
                                <td>
                                    @if($color->status)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-warning btn-sm editBtn"
                                            data-id="{{ $color->id }}"
                                            data-name="{{ $color->name }}"
                                            data-color="{{ $color->color_code }}"
                                            data-status="{{ $color->status }}">
                                        Edit
                                    </button>

                                    <form action="{{ route('color.destroy', $color->id) }}"
                                          method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete Color?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No Colors Found</td>
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
                <h5 class="modal-title">Edit Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Color Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <label>Color Hex Code</label>
                        <div class="d-flex gap-2">
                            <input type="color"
                                   id="editColorPicker"
                                   class="form-control form-control-color"
                                   style="width: 45px; height: 38px; padding: 2px;"
                                   oninput="document.getElementById('editColorHex').value = this.value">
                            <input type="text"
                                   name="color_code"
                                   id="editColorHex"
                                   class="form-control"
                                   required
                                   oninput="document.getElementById('editColorPicker').value = this.value">
                        </div>
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
                    <button type="submit" class="btn btn-primary">Update Color</button>
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
            document.getElementById("editColorHex").value = this.dataset.color;
            document.getElementById("editColorPicker").value = this.dataset.color;
            document.getElementById("editStatus").value = this.dataset.status;
            document.getElementById("editForm").action = "/color/update/" + this.dataset.id;

            new bootstrap.Modal(modal).show();
        });
    });
});
</script>

@endsection
