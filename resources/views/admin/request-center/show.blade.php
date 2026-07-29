@extends('layout.admin')

@section('title', 'Request #' . $request->request_number)
@section('page-title', 'Request #' . $request->request_number)

@section('content')
<div class="container-fluid px-4">

    <!-- Status Banner -->
    <div class="alert @if($request->status === 'approved') alert-success @elseif($request->status === 'rejected') alert-danger @elseif($request->status === 'need_more_info') alert-info @else alert-warning @endif d-flex align-items-center">
        <i class="fas fa-@if($request->status === 'approved') check-circle @elseif($request->status === 'rejected') times-circle @elseif($request->status === 'need_more_info') info-circle @else hourglass-half @endif fa-2x me-3"></i>
        <div>
            <strong>Status: {{ ucfirst(str_replace('_', ' ', $request->status)) }}</strong>
            @if($request->reviewed_at)
                <br><small>Reviewed on {{ $request->reviewed_at->format('d M Y, h:i A') }}</small>
            @endif
        </div>
        <div class="ms-auto">
            <a href="{{ route('admin.request-center.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Seller Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-store me-2 text-primary"></i> Seller Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Business Name:</strong> {{ $request->seller ? $request->seller->business_name : 'N/A' }}</p>
                            <p><strong>Owner Name:</strong> {{ $request->seller ? $request->seller->owner_name : 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $request->seller ? $request->seller->email : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Phone:</strong> {{ $request->seller ? $request->seller->phone : 'N/A' }}</p>
                            <p><strong>Product:</strong> {{ $request->product ? $request->product->title : 'N/A' }}</p>
                            <p><strong>Variant:</strong> {{ $request->variant ? ($request->variant->color ? $request->variant->color->name : 'N/A') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Compare View -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-not-equal me-2 text-warning"></i> Changes Comparison</h5>
                </div>
                <div class="card-body">
                    @if($request->request_type === 'product_edit')
                    <div class="comparison-table">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20%;">Field</th>
                                    <th style="width: 40%;" class="text-muted">Current Live Data</th>
                                    <th style="width: 40%;" class="text-primary">Requested Changes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $current = $request->current_data['product'] ?? [];
                                    $requested = $request->requested_data['product'] ?? [];
                                    $fields = ['title' => 'Product Name', 'description' => 'Description', 'category' => 'Category', 'brand' => 'Brand'];
                                @endphp
                                @foreach($fields as $key => $label)
                                @php
                                    $oldVal = $current[$key] ?? ($current['category_id'] ?? 'N/A');
                                    $newVal = $requested[$key] ?? ($requested['category_id'] ?? 'N/A');
                                    $hasChange = isset($requested[$key]) && (!isset($current[$key]) || $requested[$key] !== $current[$key]);
                                    
                                    // For category_id, compare differently
                                    if ($key === 'category' || $key === 'brand') $hasChange = false;
                                @endphp
                                <tr class="{{ $hasChange ? 'table-warning' : '' }}">
                                    <td><strong>{{ $label }}</strong></td>
                                    <td class="{{ $hasChange ? 'text-decoration-line-through' : '' }}">
                                        @if($key === 'description')
                                            {{ isset($current[$key]) ? \Illuminate\Support\Str::limit($current[$key], 100) : 'N/A' }}
                                        @else
                                            {{ $current[$key] ?? (($key === 'category') ? ($current['category'] ?? 'N/A') : (($key === 'brand') ? ($current['brand'] ?? 'N/A') : 'N/A')) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($hasChange)
                                            <span class="text-success fw-bold">
                                                @if($key === 'description')
                                                    {{ isset($requested[$key]) ? \Illuminate\Support\Str::limit($requested[$key], 100) : 'N/A' }}
                                                @else
                                                    {{ $requested[$key] ?? 'N/A' }}
                                                @endif
                                                <i class="fas fa-arrow-right ms-1"></i>
                                            </span>
                                        @else
                                            @if($key === 'description')
                                                {{ isset($requested[$key]) ? \Illuminate\Support\Str::limit($requested[$key], 100) : (isset($current[$key]) ? \Illuminate\Support\Str::limit($current[$key], 100) : 'N/A') }}
                                            @else
                                                {{ $requested[$key] ?? $current[$key] ?? 'N/A' }}
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if(isset($requested['category_id']) && $requested['category_id'] !== ($current['category_id'] ?? null))
                                <tr class="table-warning">
                                    <td><strong>Category</strong></td>
                                    <td class="text-decoration-line-through">{{ $current['category'] ?? 'ID: '.($current['category_id'] ?? 'N/A') }}</td>
                                    <td><span class="text-success fw-bold">{{ App\Models\Category::find($requested['category_id'])->name ?? 'ID: '.$requested['category_id'] }} <i class="fas fa-arrow-right ms-1"></i></span></td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @elseif($request->request_type === 'product_delete')
                    <div class="text-center py-4">
                        <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                        <h5 class="text-danger">Product Deletion Request</h5>
                        <p class="text-muted">The product <strong>"{{ $request->product ? $request->product->title : '' }}"</strong> will be permanently deleted upon approval.</p>
                    </div>
                    @elseif($request->request_type === 'variant_edit')
                    <div class="comparison-table">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 20%;">Field</th>
                                    <th style="width: 40%;" class="text-muted">Current Live Data</th>
                                    <th style="width: 40%;" class="text-primary">Requested Changes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $currentV = $request->current_data['variant'] ?? [];
                                @endphp
                                <tr class="{{ isset($request->requested_data['variant']['color_id']) && $request->requested_data['variant']['color_id'] !== ($currentV['color_id'] ?? null) ? 'table-warning' : '' }}">
                                    <td><strong>Color</strong></td>
                                    <td>{{ $currentV['color_name'] ?? 'N/A' }}</td>
                                    <td>
                                        @if(isset($request->requested_data['variant']['color_id']) && $request->requested_data['variant']['color_id'] !== ($currentV['color_id'] ?? null))
                                            <span class="text-success fw-bold">{{ App\Models\Color::find($request->requested_data['variant']['color_id'])->name ?? 'Updated' }} <i class="fas fa-arrow-right"></i></span>
                                        @else
                                            {{ $currentV['color_name'] ?? 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr class="{{ isset($request->requested_data['variant']['priority']) && $request->requested_data['variant']['priority'] !== ($currentV['priority'] ?? null) ? 'table-warning' : '' }}">
                                    <td><strong>Priority</strong></td>
                                    <td>{{ $currentV['priority'] ?? 'N/A' }}</td>
                                    <td>
                                        @if(isset($request->requested_data['variant']['priority']) && $request->requested_data['variant']['priority'] !== ($currentV['priority'] ?? null))
                                            <span class="text-success fw-bold">{{ $request->requested_data['variant']['priority'] }} <i class="fas fa-arrow-right"></i></span>
                                        @else
                                            {{ $currentV['priority'] ?? 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>SKU</strong></td>
                                    <td>{{ $currentV['sku'] ?? 'N/A' }}</td>
                                    <td>{{ $request->requested_data['variant']['sku'] ?? $currentV['sku'] ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @elseif($request->request_type === 'variant_delete')
                    <div class="text-center py-4">
                        <i class="fas fa-trash-alt fa-4x text-danger mb-3"></i>
                        <h5 class="text-danger">Variant Deletion Request</h5>
                        <p class="text-muted">The variant <strong>"{{ $request->variant ? ($request->variant->color ? $request->variant->color->name : '') : '' }}"</strong> will be deleted upon approval.</p>
                    </div>
                    @endif

                    <!-- Reason & Notes -->
                    <div class="mt-4 p-3 bg-light rounded">
                        <h6><i class="fas fa-quote-left me-2"></i>Seller's Reason</h6>
                        <p class="mb-0">{{ $request->reason ?? 'No reason provided' }}</p>
                    </div>
                    @if($request->notes)
                    <div class="mt-3 p-3 bg-light rounded">
                        <h6><i class="fas fa-sticky-note me-2"></i>Additional Notes</h6>
                        <p class="mb-0">{{ $request->notes }}</p>
                    </div>
                    @endif
                    @if($request->attachment)
                    <div class="mt-3">
                        <a href="{{ asset($request->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-paperclip me-1"></i> View Attachment
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Conversation -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-comments me-2 text-primary"></i> Conversation with Seller</h5>
                </div>
                <div class="card-body">
                    @if($request->conversations->count() > 0)
                        <div class="conversation-thread mb-4">
                            @foreach($request->conversations as $conv)
                                <div class="d-flex mb-3 {{ $conv->admin_id ? '' : 'justify-content-end' }}">
                                    <div class="message-bubble {{ $conv->admin_id ? 'admin-message' : 'seller-message' }}" style="max-width: 75%;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong class="small">
                                                @if($conv->admin_id)
                                                    <i class="fas fa-shield-alt me-1"></i> You (Admin)
                                                @elseif($conv->seller_id)
                                                    <i class="fas fa-store me-1"></i> {{ $request->seller ? $request->seller->business_name : 'Seller' }}
                                                @endif
                                            </strong>
                                            <small class="text-muted">{{ $conv->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0">{{ $conv->message }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">No messages yet.</p>
                    @endif

                    <form action="{{ route('admin.request-center.add-message', $request->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <textarea name="message" class="form-control" rows="2" placeholder="Type your message..." required maxlength="1000"></textarea>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i> Send
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Admin Actions -->
            @if(in_array($request->status, ['pending', 'need_more_info']))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-gavel me-2 text-primary"></i> Admin Actions</h5>
                </div>
                <div class="card-body">
                    <!-- Approve Form -->
                    <form action="{{ route('admin.request-center.approve', $request->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">Admin Notes (Optional)</label>
                            <textarea name="admin_notes" class="form-control form-control-sm" rows="2" placeholder="Optional notes..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-1"></i> Approve Request
                        </button>
                    </form>

                    <!-- Need More Info Form -->
                    <form action="{{ route('admin.request-center.request-more-info', $request->id) }}" method="POST" class="mb-3">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">Message to Seller <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control form-control-sm" rows="2" placeholder="Ask for more details..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-question-circle me-1"></i> Need More Information
                        </button>
                    </form>

                    <!-- Reject Form -->
                    <form action="{{ route('admin.request-center.reject', $request->id) }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label small">Rejection Reason <span class="text-danger">*</span></label>
                            <textarea name="reject_reason" class="form-control form-control-sm" rows="2" placeholder="Reason for rejection..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to reject this request?')">
                            <i class="fas fa-times me-1"></i> Reject Request
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Request Info -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-muted"></i> Request Info</h5>
                </div>
                <div class="card-body">
                    <p><strong>Request Type:</strong><br>{{ ucfirst(str_replace('_', ' ', $request->request_type)) }}</p>
                    <p><strong>Created:</strong><br>{{ $request->created_at->format('d M Y, h:i A') }}</p>
                    <p><strong>Last Updated:</strong><br>{{ $request->updated_at->diffForHumans() }}</p>
                    @if($request->reviewer)
                    <p><strong>Reviewed By:</strong><br>{{ $request->reviewer->name ?? 'N/A' }}</p>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-clock me-2 text-muted"></i> Timeline</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="d-flex mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; min-width: 32px;">
                                <i class="fas fa-plus fa-xs"></i>
                            </div>
                            <div>
                                <strong>Request Created</strong>
                                <small class="d-block text-muted">{{ $request->created_at->format('d M Y, h:i A') }}</small>
                            </div>
                        </li>
                        @if($request->reviewed_at)
                        <li class="d-flex mb-3">
                            <div class="@if($request->status === 'approved') bg-success @elseif($request->status === 'rejected') bg-danger @else bg-info @endif text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; min-width: 32px;">
                                <i class="fas fa-@if($request->status === 'approved') check @elseif($request->status === 'rejected') times @else info @endif fa-xs"></i>
                            </div>
                            <div>
                                <strong>Request {{ ucfirst($request->status) }}</strong>
                                <small class="d-block text-muted">{{ $request->reviewed_at->format('d M Y, h:i A') }}</small>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.message-bubble {
    padding: 10px 15px;
    border-radius: 15px;
}
.message-bubble.seller-message {
    background: #e7f1ff;
    border-top-left-radius: 5px;
}
.message-bubble.admin-message {
    background: #f0f2f5;
    border-top-right-radius: 5px;
}
.text-decoration-line-through {
    text-decoration: line-through;
}
.table-warning td {
    background-color: #fff3cd;
}
</style>
@endsection
