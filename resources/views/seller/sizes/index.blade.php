@extends('layout.seller')

@section('page-title', 'Sizes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:var(--nykaa-dark);">My Sizes</h4>
        <p class="text-muted mb-0">Manage your product size options</p>
    </div>
</div>

<div class="row align-items-start">
    {{-- LEFT: Add Size --}}
    <div class="col-lg-4 col-md-12 mb-4">
        <div class="seller-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-plus-circle me-2" style="color:var(--nykaa-pink);"></i>Add Size</h5>
            </div>
            <form action="{{ route('seller.sizes.store') }}" method="POST">
                @csrf
                <div class="card-body-custom">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Size Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. 50 ml, 3.5 gm, Small" required style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
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
                    <button class="btn-nykaa w-100">Save Size</button>
                </div>
            </form>
        </div>
    </div>

    {{-- RIGHT: Size List --}}
    <div class="col-lg-8 col-md-12">
        <div class="seller-card">
            <div class="card-header-custom">
                <h5><i class="fas fa-list me-2" style="color:var(--nykaa-pink);"></i>Size List</h5>
            </div>
            <div class="card-body-custom p-0">
                <div class="table-responsive">
                    <table class="seller-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($sizes as $size)
                            <tr>
                                <td><span class="fw-semibold">#{{ $size->id }}</span></td>
                                <td>{{ $size->name }}</td>
                                <td>
                                    @if($size->status)
                                        <span class="badge-nykaa bg-active">Active</span>
                                    @else
                                        <span class="badge-nykaa bg-inactive">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button"
                                                class="btn-action edit"
                                                data-id="{{ $size->id }}"
                                                data-name="{{ $size->name }}"
                                                data-status="{{ $size->status }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <form action="{{ route('seller.sizes.destroy', $size->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-action delete" onclick="return confirm('Delete this size?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5" style="color:var(--nykaa-text-light);">
                                    <i class="fas fa-ruler fa-2x mb-2 d-block"></i>
                                    No sizes created yet.
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
                <h5 class="modal-title"><i class="fas fa-edit me-2" style="color:var(--nykaa-pink);"></i>Edit Size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Size Name</label>
                        <input type="text" name="name" id="editName" class="form-control" required style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
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
                    <button type="submit" class="btn-nykaa">Update Size</button>
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
                document.getElementById("editStatus").value = this.dataset.status;
                document.getElementById("editForm").action = "{{ url('seller/sizes') }}/" + this.dataset.id;
                new bootstrap.Modal(modal).show();
            });
        });
    }
});
</script>
@endpush
@endsection