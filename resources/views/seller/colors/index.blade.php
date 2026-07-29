@extends('layout.seller')

@section('page-title', 'Colors')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:var(--nykaa-dark);">My Colors</h4>
        <p class="text-muted mb-0">Manage your product color options</p>
    </div>
</div>

<div class="row align-items-start">
    {{-- LEFT: Add Color --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="seller-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-plus-circle me-2" style="color:var(--nykaa-pink);"></i>Add Color</h5>
            </div>
            <form action="{{ route('seller.colors.store') }}" method="POST">
                @csrf
                <div class="card-body-custom">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Color Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Pink, Red" required style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Color Hex Code</label>
                        <div class="d-flex gap-2">
                            <input type="color" id="color_picker" class="form-control form-control-color" style="width: 45px; height: 38px; padding: 2px; border:1.5px solid var(--nykaa-border);border-radius:8px;" value="#ff0000" oninput="document.getElementById('color_hex').value = this.value">
                            <input type="text" name="color_code" id="color_hex" class="form-control" placeholder="#ff0000" value="#ff0000" required oninput="document.getElementById('color_picker').value = this.value" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Status</label>
                        <select name="status" class="form-select" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="p-3 border-top" style="border-color:var(--nykaa-border)!important;">
                    <button class="btn-nykaa w-100">Save Color</button>
                </div>
            </form>
        </div>
    </div>

    {{-- RIGHT: Color List --}}
    <div class="col-lg-8 col-md-12">
        <div class="seller-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-list me-2" style="color:var(--nykaa-pink);"></i>Color List</h5>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="seller-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Preview</th>
                                <th>Name</th>
                                <th>Hex Code</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($colors as $color)
                            <tr>
                                <td><span class="fw-semibold">#{{ $color->id }}</span></td>
                                <td>
                                    <div style="width: 32px; height: 32px; border-radius: 50%; background-color: {{ $color->color_code }}; border: 2px solid #eee;"></div>
                                </td>
                                <td>{{ $color->name }}</td>
                                <td><code style="background:#f5f5f5;padding:3px 8px;border-radius:4px;">{{ $color->color_code }}</code></td>
                                <td>
                                    @if($color->status)
                                        <span class="badge-nykaa bg-active">Active</span>
                                    @else
                                        <span class="badge-nykaa bg-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button"
                                                class="btn-action edit"
                                                data-id="{{ $color->id }}"
                                                data-name="{{ $color->name }}"
                                                data-color="{{ $color->color_code }}"
                                                data-status="{{ $color->status }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('seller.colors.destroy', $color->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-action delete" onclick="return confirm('Delete this color?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5" style="color:var(--nykaa-text-light);">
                                    <i class="fas fa-palette fa-2x mb-2 d-block"></i>
                                    No colors created yet.
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

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-nykaa">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2" style="color:var(--nykaa-pink);"></i>Edit Color</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Color Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Color Hex Code</label>
                        <div class="d-flex gap-2">
                            <input type="color" id="editColorPicker" class="form-control form-control-color" style="width: 45px; height: 38px; padding: 2px; border:1.5px solid var(--nykaa-border);border-radius:8px;" oninput="document.getElementById('editColorHex').value = this.value">
                            <input type="text" name="color_code" id="editColorHex" class="form-control" required oninput="document.getElementById('editColorPicker').value = this.value" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Status</label>
                        <select name="status" id="editStatus" class="form-select" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-action" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn-nykaa">Update Color</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const editButtons = document.querySelectorAll(".btn-action.edit");
    const modal = document.getElementById("editModal");
    if (modal) {
        editButtons.forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("editName").value = this.dataset.name;
                document.getElementById("editColorHex").value = this.dataset.color;
                document.getElementById("editColorPicker").value = this.dataset.color;
                document.getElementById("editStatus").value = this.dataset.status;
                document.getElementById("editForm").action = "{{ url('seller/colors') }}/" + this.dataset.id;
                new bootstrap.Modal(modal).show();
            });
        });
    }
});
</script>
@endpush
@endsection