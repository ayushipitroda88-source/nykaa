@extends('layout.seller')

@section('page-title', 'Request #' . $request->request_number)

@section('page-header')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Request #{{ $request->request_number }}</h4>
        <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $request->request_type)) }} Request</small>
    </div>
    <a href="{{ route('seller.request-center.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i> Back to Requests
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Status Banner -->
    <div class="alert @if($request->status === 'approved') alert-success @elseif($request->status === 'rejected') alert-danger @elseif($request->status === 'need_more_info') alert-info @else alert-warning @endif d-flex align-items-center">
        <i class="fas fa-@if($request->status === 'approved') check-circle @elseif($request->status === 'rejected') times-circle @elseif($request->status === 'need_more_info') info-circle @else hourglass-half @endif fa-2x me-3"></i>
        <div>
            <strong>Status: {{ ucfirst(str_replace('_', ' ', $request->status)) }}</strong>
            @if($request->reviewed_at)
                <br><small>Reviewed on {{ $request->reviewed_at->format('d M Y, h:i A') }}</small>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Compare View -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-compare me-2 text-primary"></i> Changes Review</h5>
                </div>
                <div class="card-body">
                    @if($request->request_type === 'product_edit' || $request->request_type === 'product_delete')
                    <!-- Product Comparison -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-database me-1 text-muted"></i> Current Product</h6>
                                </div>
                                <div class="card-body">
                                    @if($request->current_data && isset($request->current_data['product']))
                                        <p><strong>Title:</strong><br>{{ $request->current_data['product']['title'] ?? 'N/A' }}</p>
                                        <p><strong>Description:</strong><br>{{ $request->current_data['product']['description'] ?? 'N/A' }}</p>
                                        <p><strong>Category:</strong><br>{{ $request->current_data['product']['category'] ?? 'N/A' }}</p>
                                        <p><strong>Brand:</strong><br>{{ $request->current_data['product']['brand'] ?? 'N/A' }}</p>
                                    @else
                                        <p class="text-muted">No data available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-file-invoice me-1 text-warning"></i> Requested Product</h6>
                                </div>
                                <div class="card-body">
                                    @if($request->requested_data && isset($request->requested_data['product']))
                                        @php $current = $request->current_data['product'] ?? []; @endphp
                                        @php $requested = $request->requested_data['product']; @endphp
                                        <p>
                                            <strong>Title:</strong><br>
                                            @if(isset($requested['title']) && (!isset($current['title']) || $requested['title'] !== $current['title']))
                                                <span class="text-success fw-bold">{{ $requested['title'] }}</span>
                                                @if(isset($current['title']))
                                                    <br><small class="text-muted text-decoration-line-through">{{ $current['title'] }}</small>
                                                @endif
                                            @else
                                                {{ $requested['title'] ?? 'N/A' }}
                                            @endif
                                        </p>
                                        <p>
                                            <strong>Description:</strong><br>
                                            @if(isset($requested['description']) && (!isset($current['description']) || $requested['description'] !== $current['description']))
                                                <span class="text-success fw-bold">{{ \Illuminate\Support\Str::limit($requested['description'], 100) }}</span>
                                            @else
                                                {{ isset($requested['description']) ? \Illuminate\Support\Str::limit($requested['description'], 100) : 'N/A' }}
                                            @endif
                                        </p>
                                        <p>
                                            <strong>Category ID:</strong><br>
                                            @if(isset($requested['category_id']) && (!isset($current['category_id']) || $requested['category_id'] !== $current['category_id']))
                                                <span class="text-success fw-bold">{{ $requested['category_id'] }}</span>
                                                @if(isset($current['category_id']))
                                                    <br><small class="text-muted text-decoration-line-through">{{ $current['category_id'] }}</small>
                                                @endif
                                            @else
                                                {{ $requested['category_id'] ?? 'N/A' }}
                                            @endif
                                        </p>
                                    @elseif($request->request_type === 'product_delete')
                                        <div class="text-center py-4">
                                            <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                                            <h6 class="text-danger">This product will be deleted upon approval</h6>
                                        </div>
                                    @else
                                        <p class="text-muted">No changes requested</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($request->request_type === 'variant_edit' || $request->request_type === 'variant_delete')
                    <!-- Variant Comparison -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-database me-1 text-muted"></i> Current Variant</h6>
                                </div>
                                <div class="card-body">
                                    @if($request->current_data && isset($request->current_data['variant']))
                                        @php $v = $request->current_data['variant']; @endphp
                                        <p><strong>Color:</strong> {{ $v['color_name'] ?? 'N/A' }}</p>
                                        <p><strong>Priority:</strong> {{ $v['priority'] ?? 'N/A' }}</p>
                                        <p><strong>SKU:</strong> {{ $v['sku'] ?? 'N/A' }}</p>
                                        <p><strong>Status:</strong> {{ $v['status'] ? 'Active' : 'Inactive' }}</p>
                                        @if(isset($v['sizes']) && count($v['sizes']) > 0)
                                            <p><strong>Sizes:</strong></p>
                                            <ul class="list-unstyled">
                                                @foreach($v['sizes'] as $size)
                                                    <li class="small">{{ $size['size_name'] ?? 'N/A' }} - ₹{{ number_format($size['price'] ?? 0) }} (Qty: {{ $size['quantity'] ?? 0 }})</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @else
                                        <p class="text-muted">No data available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-file-invoice me-1 text-warning"></i> Requested Variant</h6>
                                </div>
                                <div class="card-body">
                                    @if($request->request_type === 'variant_delete')
                                        <div class="text-center py-4">
                                            <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                                            <h6 class="text-danger">This variant will be deleted upon approval</h6>
                                        </div>
                                    @else
                                        <p class="text-muted">Variant edit details shown to admin only (full edit form)</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Request Details -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i> Request Details</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Request Number:</strong><br>{{ $request->request_number }}</p>
                            <p><strong>Request Type:</strong><br>{{ ucfirst(str_replace('_', ' ', $request->request_type)) }}</p>
                            <p><strong>Product:</strong><br>{{ $request->product ? $request->product->title : 'N/A' }}</p>
                            @if($request->variant)
                            <p><strong>Variant:</strong><br>{{ $request->variant->color ? $request->variant->color->name : 'N/A' }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong><br>
                                <span class="badge @if($request->status === 'approved') bg-success @elseif($request->status === 'rejected') bg-danger @elseif($request->status === 'need_more_info') bg-info @else bg-warning text-dark @endif p-2">
                                    {{ ucfirst(str_replace('_', ' ', $request->status)) }}
                                </span>
                            </p>
                            <p><strong>Created:</strong><br>{{ $request->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Last Updated:</strong><br>{{ $request->updated_at->diffForHumans() }}</p>
                            @if($request->reviewer)
                            <p><strong>Reviewed By:</strong><br>{{ $request->reviewer->name ?? 'N/A' }}</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <p><strong>Reason:</strong></p>
                        <p class="bg-light p-3 rounded">{{ $request->reason ?? 'No reason provided' }}</p>
                    </div>

                    @if($request->notes)
                    <div class="mt-3">
                        <p><strong>Additional Notes:</strong></p>
                        <p class="bg-light p-3 rounded">{{ $request->notes }}</p>
                    </div>
                    @endif

                    @if($request->admin_notes)
                    <div class="mt-3">
                        <p><strong>Admin Notes:</strong></p>
                        <p class="bg-light p-3 rounded">{{ $request->admin_notes }}</p>
                    </div>
                    @endif

                    @if($request->attachment)
                    <div class="mt-3">
                        <p><strong>Attachment:</strong></p>
                        <a href="{{ asset($request->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download me-1"></i> View Attachment
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Conversation -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-comments me-2 text-primary"></i> Conversation</h5>
                </div>
                <div class="card-body">
                    @if($request->conversations->count() > 0)
                        <div class="conversation-thread mb-4">
                            @foreach($request->conversations as $conv)
                                <div class="d-flex mb-3 {{ $conv->seller_id ? '' : 'justify-content-end' }}">
                                    <div class="message-bubble {{ $conv->seller_id ? 'seller-message' : 'admin-message' }}" style="max-width: 75%;">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong class="small">
                                                @if($conv->seller_id)
                                                    <i class="fas fa-store me-1"></i> You
                                                @elseif($conv->admin_id)
                                                    <i class="fas fa-shield-alt me-1"></i> Admin
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

                    @if($request->status === 'need_more_info' || $request->status === 'pending')
                    <form action="{{ route('seller.request-center.add-message', $request->id) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <textarea name="message" class="form-control" rows="2" placeholder="Type your message..." required maxlength="1000"></textarea>
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i> Send
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Actions Card -->
            @if(in_array($request->status, ['rejected', 'need_more_info']))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-tools me-2 text-warning"></i> Actions</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small">
                        @if($request->status === 'rejected')
                            Your request was rejected. You can modify and resubmit.
                        @else
                            Admin has requested more information. Please respond above.
                        @endif
                    </p>
                    <a href="{{ route('seller.request-center.edit', $request->id) }}" class="btn btn-warning w-100">
                        <i class="fas fa-redo me-1"></i> 
                        @if($request->status === 'rejected') Resubmit Request @else Update & Resubmit @endif
                    </a>
                </div>
            </div>
            @endif

            <!-- Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-clock me-2 text-muted"></i> Timeline</h5>
                </div>
                <div class="card-body">
                    <ul class="timeline list-unstyled">
                        <li class="d-flex mb-3">
                            <div class="timeline-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; min-width: 32px;">
                                <i class="fas fa-plus fa-xs"></i>
                            </div>
                            <div>
                                <strong class="d-block">Request Created</strong>
                                <small class="text-muted">{{ $request->created_at->format('d M Y, h:i A') }}</small>
                            </div>
                        </li>
                        @if($request->reviewed_at)
                        <li class="d-flex mb-3">
                            <div class="timeline-icon @if($request->status === 'approved') bg-success @elseif($request->status === 'rejected') bg-danger @else bg-info @endif text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; min-width: 32px;">
                                <i class="fas fa-@if($request->status === 'approved') check @elseif($request->status === 'rejected') times @else info @endif fa-xs"></i>
                            </div>
                            <div>
                                <strong class="d-block">Request {{ ucfirst($request->status) }}</strong>
                                <small class="text-muted">{{ $request->reviewed_at->format('d M Y, h:i A') }}</small>
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
    background: #f0f2f5;
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
</style>
@endsection
</write_to_file>