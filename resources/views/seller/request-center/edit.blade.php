@extends('layout.seller')

@section('page-title', 'Resubmit Request #' . $requestCenterRequest->request_number)

@section('page-header')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Resubmit Request #{{ $requestCenterRequest->request_number }}</h4>
        <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $requestCenterRequest->request_type)) }} Request</small>
    </div>
    <a href="{{ route('seller.request-center.show', $requestCenterRequest->id) }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Request
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('seller.request-center.update', $requestCenterRequest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="request_type" value="{{ $requestCenterRequest->request_type }}">
                <input type="hidden" name="product_id" value="{{ $requestCenterRequest->product_id }}">
                @if($requestCenterRequest->variant_id)
                    <input type="hidden" name="variant_id" value="{{ $requestCenterRequest->variant_id }}">
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Product</label>
                            <p class="form-control-plaintext">{{ $product->title ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Request Type</label>
                            <p class="form-control-plaintext">{{ ucfirst(str_replace('_', ' ', $requestCenterRequest->request_type)) }}</p>
                        </div>
                    </div>
                </div>

                @if($requestCenterRequest->request_type === 'product_edit')
                <div class="mb-3">
                    <label class="form-label">Product Title <span class="text-danger">*</span></label>
                    <input type="text" name="product_title" class="form-control" 
                           value="{{ old('product_title', $requestCenterRequest->requested_data['product']['title'] ?? $product->title) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description <span class="text-danger">*</span></label>
                    <textarea name="product_description" class="form-control" rows="4">{{ old('product_description', $requestCenterRequest->requested_data['product']['description'] ?? $product->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select">
                        <option value="">-- Select Category --</option>
                        @foreach($mainCategories as $cat)
                            <option value="{{ $cat->id }}" 
                                {{ old('category_id', $requestCenterRequest->requested_data['product']['category_id'] ?? $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Reason <span class="text-danger">*</span></label>
                    <textarea name="reason" class="form-control" rows="3">{{ old('reason', $requestCenterRequest->reason) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Additional Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $requestCenterRequest->notes) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Attachment (Optional)</label>
                    @if($requestCenterRequest->attachment)
                        <div class="mb-2">
                            <a href="{{ asset($requestCenterRequest->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-file me-1"></i> View Current Attachment
                            </a>
                        </div>
                    @endif
                    <input type="file" name="attachment" class="form-control">
                    <small class="text-muted">Upload new file to replace existing attachment.</small>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('seller.request-center.show', $requestCenterRequest->id) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-redo me-1"></i> Resubmit Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
</write_to_file>
</rewrite_file>