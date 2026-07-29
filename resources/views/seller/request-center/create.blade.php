@extends('layout.seller')

@section('page-title', 'Create Request')

@section('page-header')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Create New Request</h4>
        <small class="text-muted">Submit a change request for review</small>
    </div>
    <a href="{{ route('seller.request-center.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Requests
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('seller.request-center.store') }}" method="POST" enctype="multipart/form-data" id="requestForm">
                        @csrf

                        <!-- Step 1: Request Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Request Type <span class="text-danger">*</span></label>
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <div class="request-type-card {{ $requestType === 'product_edit' ? 'selected' : '' }}" 
                                         onclick="selectRequestType('product_edit')">
                                        <input type="radio" name="request_type" value="product_edit" 
                                               class="d-none" {{ $requestType === 'product_edit' ? 'checked' : '' }}
                                               onchange="toggleFields()">
                                        <div class="text-center p-3 border rounded-3 cursor-pointer type-card">
                                            <i class="fas fa-edit fa-2x text-primary mb-2"></i>
                                            <div class="fw-semibold small">Edit Product</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="request-type-card {{ $requestType === 'product_delete' ? 'selected' : '' }}" 
                                         onclick="selectRequestType('product_delete')">
                                        <input type="radio" name="request_type" value="product_delete" 
                                               class="d-none" {{ $requestType === 'product_delete' ? 'checked' : '' }}
                                               onchange="toggleFields()">
                                        <div class="text-center p-3 border rounded-3 cursor-pointer type-card">
                                            <i class="fas fa-trash fa-2x text-danger mb-2"></i>
                                            <div class="fw-semibold small">Delete Product</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="request-type-card {{ $requestType === 'variant_edit' ? 'selected' : '' }}" 
                                         onclick="selectRequestType('variant_edit')">
                                        <input type="radio" name="request_type" value="variant_edit" 
                                               class="d-none" {{ $requestType === 'variant_edit' ? 'checked' : '' }}
                                               onchange="toggleFields()">
                                        <div class="text-center p-3 border rounded-3 cursor-pointer type-card">
                                            <i class="fas fa-pen fa-2x text-info mb-2"></i>
                                            <div class="fw-semibold small">Edit Variant</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="request-type-card {{ $requestType === 'variant_delete' ? 'selected' : '' }}" 
                                         onclick="selectRequestType('variant_delete')">
                                        <input type="radio" name="request_type" value="variant_delete" 
                                               class="d-none" {{ $requestType === 'variant_delete' ? 'checked' : '' }}
                                               onchange="toggleFields()">
                                        <div class="text-center p-3 border rounded-3 cursor-pointer type-card">
                                            <i class="fas fa-times fa-2x text-warning mb-2"></i>
                                            <div class="fw-semibold small">Delete Variant</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('request_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Step 2: Select Product -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Select Product <span class="text-danger">*</span></label>
                            <select name="product_id" id="productSelect" class="form-select" onchange="onProductChange()" required>
                                <option value="">-- Select Product --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" 
                                        {{ ($product && $product->id === $p->id) ? 'selected' : '' }}
                                        data-title="{{ $p->title }}"
                                        data-description="{{ $p->description }}"
                                        data-category="{{ $p->category_id }}">
                                        {{ $p->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Step 3: Select Variant (for variant requests) -->
                        <div class="mb-4" id="variantSection" style="display: none;">
                            <label class="form-label fw-semibold">Select Variant <span class="text-danger">*</span></label>
                            <select name="variant_id" id="variantSelect" class="form-select">
                                <option value="">-- Select Variant --</option>
                            </select>
                            @error('variant_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Step 4: Product Edit Fields -->
                        <div id="productEditFields" style="display: none;">
                            <h5 class="mb-3 border-bottom pb-2">Product Details</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Product Title <span class="text-danger">*</span></label>
                                <input type="text" name="product_title" id="productTitle" class="form-control" 
                                       value="{{ $product ? $product->title : old('product_title') }}">
                                @error('product_title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea name="product_description" id="productDescription" class="form-control" rows="4">{{ $product ? $product->description : old('product_description') }}</textarea>
                                @error('product_description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Category <span class="text-danger">*</span></label>
                                <select name="category_id" id="categorySelect" class="form-select">
                                    <option value="">-- Select Category --</option>
                                    @foreach($mainCategories as $cat)
                                        <option value="{{ $cat->id }}" 
                                            {{ ($product && $product->category_id === $cat->id) ? 'selected' : (old('category_id') == $cat->id ? 'selected' : '') }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Step 5: Reason & Notes -->
                        <div class="mb-4 mt-4">
                            <h5 class="mb-3 border-bottom pb-2">Request Details</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Reason for Request <span class="text-danger">*</span></label>
                                <textarea name="reason" class="form-control" rows="3" placeholder="Explain why you need this change...">{{ old('reason') }}</textarea>
                                @error('reason')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Additional Notes</label>
                                <textarea name="notes" class="form-control" rows="2" placeholder="Any additional information...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Attachment (Optional)</label>
                                <input type="file" name="attachment" class="form-control">
                                <small class="text-muted">Allowed: JPG, PNG, PDF, DOC. Max 5MB.</small>
                                @error('attachment')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('seller.request-center.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i> Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-info"></i> How it works</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <span class="badge bg-primary rounded-circle p-2">1</span>
                        </div>
                        <div>
                            <h6 class="mb-1">Choose Request Type</h6>
                            <small class="text-muted">Select what you want to change</small>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <span class="badge bg-primary rounded-circle p-2">2</span>
                        </div>
                        <div>
                            <h6 class="mb-1">Fill Details</h6>
                            <small class="text-muted">Provide the requested changes</small>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <span class="badge bg-primary rounded-circle p-2">3</span>
                        </div>
                        <div>
                            <h6 class="mb-1">Submit for Review</h6>
                            <small class="text-muted">Admin will review your request</small>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="me-3">
                            <span class="badge bg-primary rounded-circle p-2">4</span>
                        </div>
                        <div>
                            <h6 class="mb-1">Wait for Approval</h6>
                            <small class="text-muted">Get notified when status changes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.request-type-card .type-card {
    cursor: pointer;
    transition: all 0.2s;
    background: #f8f9fa;
}
.request-type-card .type-card:hover {
    border-color: #0d6efd !important;
    background: #e7f1ff;
}
.request-type-card.selected .type-card {
    border-color: #0d6efd !important;
    background: #e7f1ff;
    box-shadow: 0 0 0 2px rgba(13,110,253,0.25);
}
</style>

@endsection

@push('scripts')
<script>
function selectRequestType(type) {
    document.querySelectorAll('input[name="request_type"]').forEach(el => el.checked = false);
    document.querySelectorAll('.request-type-card').forEach(el => el.classList.remove('selected'));
    
    const radio = document.querySelector(`input[name="request_type"][value="${type}"]`);
    if (radio) {
        radio.checked = true;
        radio.closest('.request-type-card').classList.add('selected');
        toggleFields();
    }
}

function toggleFields() {
    const type = document.querySelector('input[name="request_type"]:checked');
    if (!type) return;
    
    const val = type.value;
    const productEditFields = document.getElementById('productEditFields');
    const variantSection = document.getElementById('variantSection');
    
    // Show product edit fields only for product_edit
    productEditFields.style.display = val === 'product_edit' ? 'block' : 'none';
    
    // Show variant selector for variant requests
    variantSection.style.display = (val === 'variant_edit' || val === 'variant_delete') ? 'block' : 'none';
    
    // Set field requirements
    document.getElementById('productTitle').required = val === 'product_edit';
    document.getElementById('productDescription').required = val === 'product_edit';
    document.getElementById('categorySelect').required = val === 'product_edit';
}

function onProductChange() {
    const productId = document.getElementById('productSelect').value;
    const type = document.querySelector('input[name="request_type"]:checked');
    
    if (type && (type.value === 'variant_edit' || type.value === 'variant_delete') && productId) {
        // Load variants via AJAX
        fetch(`/seller/request-center/variants/${productId}`)
            .then(res => res.json())
            .then(variants => {
                const select = document.getElementById('variantSelect');
                select.innerHTML = '<option value="">-- Select Variant --</option>';
                variants.forEach(v => {
                    select.innerHTML += `<option value="${v.id}">${v.label}</option>`;
                });
                
                // Pre-select if editing a specific variant
                @if($variant)
                select.value = '{{ $variant->id }}';
                @endif
                
                document.getElementById('variantSection').style.display = 'block';
            });
    } else if (productId) {
        // Fill product fields
        const selected = document.querySelector(`#productSelect option[value="${productId}"]`);
        if (selected) {
            document.getElementById('productTitle').value = selected.dataset.title || '';
            document.getElementById('productDescription').value = selected.dataset.description || '';
            const category = selected.dataset.category;
            if (category) {
                document.getElementById('categorySelect').value = category;
            }
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleFields();
    @if($product)
    onProductChange();
    @endif
});
</script>
@endpush
</write_to_file>

</write_to_file>