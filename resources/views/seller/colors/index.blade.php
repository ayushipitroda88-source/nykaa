@extends('layout.seller')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">My Colors</h3>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row align-items-start">
    <!-- LEFT SIDE: Add Color -->
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pb-0 pt-4">
                <h5 class="fw-bold">Add Color</h5>
            </div>
            <form action="{{ route('seller.colors.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label">Color Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Pink, Red" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Color Hex Code</label>
                        <div class="d-flex gap-2">
                            <input type="color" id="color_picker" class="form-control form-control-color" style="width: 45px; height: 38px; padding: 2px;" value="#ff0000" oninput="document.getElementById('color_hex').value = this.value">
                            <input type="text" name="color_code" id="color_hex" class="form-control" placeholder="#ff0000" value="#ff0000" required oninput="document.getElementById('color_picker').value = this.value">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <button class="btn btn-primary">Save Color</button>
                </div>
            </form>
        </div>
    </div>

    <!-- RIGHT SIDE: Color List -->
    <div class="col-lg-8 col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white pb-0 pt-4">
                <h5 class="fw-bold">Color List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
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
                                    <form action="{{ route('seller.colors.destroy', $color->id) }}"
                                          method="POST"
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this color?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No colors created yet.</td>
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
                    <div class="form-group mb-3">
                        <label class="form-label">Color Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Color Hex Code</label>
                        <div class="d-flex gap-2">
                            <input type="color" id="editColorPicker" class="form-control form-control-color" style="width: 45px; height: 38px; padding: 2px;" oninput="document.getElementById('editColorHex').value = this.value">
                            <input type="text" name="color_code" id="editColorHex" class="form-control" required oninput="document.getElementById('editColorPicker').value = this.value">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="editStatus" class="form-select">
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
    if (modal) {
        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("editName").value = this.dataset.name;
                document.getElementById("editColorHex").value = this.dataset.color;
                document.getElementById("editColorPicker").value = this.dataset.color;
                document.getElementById("editStatus").value = this.dataset.status;
                document.getElementById("editForm").action = "{{ url('seller/colors/update') }}/" + this.dataset.id;
                new bootstrap.Modal(modal).show();
            });
        });
    }
});
</script>
@endsection