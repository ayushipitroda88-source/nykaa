@extends('layout.seller')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Variants for: {{ $product->title }}</h3>
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('seller.products.index') }}" class="btn btn-secondary">Back to Products</a>
        @if($availableColors->count() > 0)
            <button type="button" id="addVariantRow" class="btn btn-primary">➕ Add Color Variant</button>
        @else
            <div class="text-danger small" style="max-width: 300px; line-height: 1.2;">
                <strong>All available colors have already been added for this product.</strong><br>
                Please create a new color from Seller Colors if you want to add another variant.
            </div>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('seller.variants.sync', $product->id) }}" method="POST" enctype="multipart/form-data" id="variantsForm">
    @csrf
    
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0" id="variantsTable">
                    <thead class="table-light">
                        <tr>
                            <th width="80">Priority</th>
                            <th width="150">Color</th>
                            <th width="150">SKU</th>
                            <th>Sizes & Independent Pricing (Stock, Selling Price, Original Price)</th>
                            <th width="150">Variant Image</th>
                            <th width="120">Status</th>
                            <th width="80">Action</th>
                        </tr>
                    </thead>
                    <tbody id="variantsBody">
                        @foreach($variants as $index => $variant)
                            <tr class="variant-row" data-index="{{ $index }}">
                                <input type="hidden" name="variants[{{ $index }}][id]" value="{{ $variant->id }}">
                                
                                <td>
                                    <input type="number" name="variants[{{ $index }}][priority]" class="form-control text-center" value="{{ $variant->priority }}" required min="1">
                                    <div class="text-center mt-1"><span class="badge bg-info">Default</span></div>
                                </td>
                                
                                <td>
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="width: 20px; height: 20px; border-radius: 50%; display: inline-block; background-color: {{ $variant->color->color_code ?? '#ccc' }}; border: 1px solid #ddd;"></span>
                                        <span>{{ $variant->color->name ?? 'N/A' }}</span>
                                    </div>
                                    <select name="variants[{{ $index }}][color_id]" class="form-select form-select-sm" required>
                                        <option value="">Select Color</option>
                                        @foreach($colors as $color)
                                            @if($variant->color_id == $color->id || $availableColors->contains('id', $color->id))
                                                <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}>{{ $color->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                
                                <td>
                                    <input type="text" name="variants[{{ $index }}][sku]" class="form-control" value="{{ $variant->sku }}" placeholder="SKU">
                                </td>
                                
                                <td class="p-3 bg-light">
                                    @foreach($sizes as $sizeIndex => $size)
                                        @php
                                            // Check if this variant has this size
                                            $hasSize = $variant->sizes->where('size_id', $size->id)->first();
                                        @endphp
                                        <div class="card mb-2 border">
                                            <div class="card-body p-2">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input size-checkbox" type="checkbox" 
                                                           id="size_{{ $index }}_{{ $size->id }}" 
                                                           {{ $hasSize ? 'checked' : '' }}
                                                           onchange="toggleSizeFields(this, {{ $index }}, {{ $size->id }})">
                                                    <label class="form-check-label fw-bold" for="size_{{ $index }}_{{ $size->id }}">
                                                        {{ $size->name }}
                                                    </label>
                                                    <input type="hidden" name="variants[{{ $index }}][sizes][{{ $sizeIndex }}][size_id]" value="{{ $size->id }}" {{ $hasSize ? '' : 'disabled' }} class="size-id-input">
                                                </div>
                                                <div class="row g-2 size-fields" style="opacity: {{ $hasSize ? '1' : '0.5' }}">
                                                    <div class="col-4">
                                                        <label class="form-label text-muted small mb-0">Stock</label>
                                                        <input type="number" name="variants[{{ $index }}][sizes][{{ $sizeIndex }}][quantity]" class="form-control form-control-sm" value="{{ $hasSize ? $hasSize->quantity : 0 }}" required min="0" {{ $hasSize ? '' : 'readonly' }}>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label text-muted small mb-0">Selling Price (₹)</label>
                                                        <input type="number" step="0.01" name="variants[{{ $index }}][sizes][{{ $sizeIndex }}][price]" class="form-control form-control-sm" value="{{ $hasSize ? $hasSize->price : '' }}" required min="0" placeholder="Selling ₹" {{ $hasSize ? '' : 'readonly' }}>
                                                    </div>
                                                    <div class="col-4">
                                                        <label class="form-label text-muted small mb-0">Original Price (₹)</label>
                                                        <input type="number" step="0.01" name="variants[{{ $index }}][sizes][{{ $sizeIndex }}][original_price]" class="form-control form-control-sm" value="{{ $hasSize ? $hasSize->original_price : '' }}" min="0" placeholder="MSRP ₹" {{ $hasSize ? '' : 'readonly' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                                
                                <td>
                                    <input type="file" name="variants[{{ $index }}][image]" class="form-control form-control-sm mb-2" accept="image/*">
                                    @if($variant->image)
                                        <div class="text-center">
                                            <img src="{{ asset('uploads/variants/'.$variant->image) }}" class="rounded img-thumbnail" style="max-height: 80px;">
                                        </div>
                                    @endif
                                </td>
                                
                                <td>
                                    <select name="variants[{{ $index }}][status]" class="form-select form-select-sm">
                                        <option value="1" {{ $variant->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $variant->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </td>
                                
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteVariant({{ $variant->id }}, this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white text-end py-3">
            <button type="submit" class="btn btn-success px-5 fw-bold">Save All Changes</button>
        </div>
    </div>
</form>

<script>
let variantIndex = {{ count($variants) }};
const availableColors = @json($availableColors);
const sizes = @json($sizes);

// Toggle size inputs readonly state based on checkbox
function toggleSizeFields(checkbox, vIndex, sizeId) {
    const cardBody = checkbox.closest('.card-body');
    const inputs = cardBody.querySelectorAll('input[type="number"]');
    const hiddenIdInput = cardBody.querySelector('.size-id-input');
    const fieldsContainer = cardBody.querySelector('.size-fields');
    
    if (checkbox.checked) {
        inputs.forEach(input => input.removeAttribute('readonly'));
        hiddenIdInput.removeAttribute('disabled');
        fieldsContainer.style.opacity = '1';
    } else {
        inputs.forEach(input => input.setAttribute('readonly', 'readonly'));
        hiddenIdInput.setAttribute('disabled', 'disabled');
        fieldsContainer.style.opacity = '0.5';
    }
}

// Add new variant row
const addVariantRowBtn = document.getElementById('addVariantRow');
if (addVariantRowBtn) {
    addVariantRowBtn.addEventListener('click', function() {
        const tbody = document.getElementById('variantsBody');
        const tr = document.createElement('tr');
        tr.className = 'variant-row';
        tr.dataset.index = variantIndex;
        
        // Generate color options
        let colorOptions = '<option value="">Select Color</option>';
        availableColors.forEach(c => {
            colorOptions += `<option value="${c.id}">${c.name}</option>`;
        });

    // Generate size cards
    let sizeCards = '';
    sizes.forEach((s, sIndex) => {
        sizeCards += `
        <div class="card mb-2 border">
            <div class="card-body p-2">
                <div class="form-check mb-2">
                    <input class="form-check-input size-checkbox" type="checkbox" 
                           id="size_${variantIndex}_${s.id}" 
                           onchange="toggleSizeFields(this, ${variantIndex}, ${s.id})">
                    <label class="form-check-label fw-bold" for="size_${variantIndex}_${s.id}">
                        ${s.name}
                    </label>
                    <input type="hidden" name="variants[${variantIndex}][sizes][${sIndex}][size_id]" value="${s.id}" disabled class="size-id-input">
                </div>
                <div class="row g-2 size-fields" style="opacity: 0.5">
                    <div class="col-4">
                        <label class="form-label text-muted small mb-0">Stock</label>
                        <input type="number" name="variants[${variantIndex}][sizes][${sIndex}][quantity]" class="form-control form-control-sm" value="0" required min="0" readonly>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted small mb-0">Selling Price (₹)</label>
                        <input type="number" step="0.01" name="variants[${variantIndex}][sizes][${sIndex}][price]" class="form-control form-control-sm" required min="0" placeholder="Selling ₹" readonly>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted small mb-0">Original Price (₹)</label>
                        <input type="number" step="0.01" name="variants[${variantIndex}][sizes][${sIndex}][original_price]" class="form-control form-control-sm" min="0" placeholder="MSRP ₹" readonly>
                    </div>
                </div>
            </div>
        </div>
        `;
    });

    tr.innerHTML = `
        <td>
            <input type="number" name="variants[${variantIndex}][priority]" class="form-control text-center" value="${variantIndex + 1}" required min="1">
        </td>
        <td>
            <select name="variants[${variantIndex}][color_id]" class="form-select form-select-sm" required>
                ${colorOptions}
            </select>
        </td>
        <td>
            <input type="text" name="variants[${variantIndex}][sku]" class="form-control" placeholder="SKU">
        </td>
        <td class="p-3 bg-light">
            ${sizeCards}
        </td>
        <td>
            <input type="file" name="variants[${variantIndex}][image]" class="form-control form-control-sm" accept="image/*" required>
        </td>
        <td>
            <select name="variants[${variantIndex}][status]" class="form-select form-select-sm">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-sm remove-new-row">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(tr);
    variantIndex++;
    });
}

// Remove new rows (not saved to DB yet)
document.getElementById('variantsBody').addEventListener('click', function(e) {
    if (e.target.closest('.remove-new-row')) {
        e.target.closest('tr').remove();
    }
});

// Delete existing variant via API call
function deleteVariant(id, btn) {
    if (confirm('Are you sure you want to delete this variant?')) {
        // Create form dynamically to submit delete
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/seller/variants/${id}`;
        
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
