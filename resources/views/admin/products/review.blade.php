@extends('layout.admin')

@section('content')
<div class="container-fluid mt-4">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.approvals') }}">📋 Product Approvals</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Review Product</li>
        </ol>
    </nav>

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h3 class="mb-1">
                🔍 Product Review
            </h3>
            <p class="text-muted mb-0 small">Inspect all product details before making your decision.</p>
        </div>
        @php
            $statusColors = [
                'pending'     => 'warning text-dark',
                'resubmitted' => 'info text-dark',
                'approved'    => 'success',
                'rejected'    => 'danger',
            ];
            $statusIcons = [
                'pending'     => '⏳',
                'resubmitted' => '🔄',
                'approved'    => '✅',
                'rejected'    => '❌',
            ];
            $sc = $statusColors[$product->status] ?? 'secondary';
            $si = $statusIcons[$product->status] ?? '•';
        @endphp
        <span class="badge bg-{{ $sc }} fs-6 px-3 py-2">
            {{ $si }} {{ ucfirst($product->status) }}
        </span>
    </div>

    {{-- Session messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Admin Decision Panel --}}
    @if(in_array($product->status, ['pending', 'resubmitted']))
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <h6 class="fw-bold mb-1"><i class="fas fa-gavel me-2 text-primary"></i>Admin Decision</h6>
            <p class="text-muted small mb-3">Review all product information below, then choose to approve or reject.</p>
            <div class="d-flex gap-2 flex-wrap">
                {{-- Approve --}}
                <form action="{{ route('admin.products.approve', $product->id) }}" method="POST"
                      onsubmit="return confirm('Approve this product?');">
                    @csrf
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-check me-2"></i>Approve Product
                    </button>
                </form>

                {{-- Reject --}}
                <button type="button" class="btn btn-danger px-4"
                        data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="fas fa-times me-2"></i>Reject Product
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- If already approved --}}
    @if($product->status === 'approved')
    <div class="alert alert-success d-flex align-items-center gap-3 mb-4 shadow-sm">
        <i class="fas fa-check-circle fa-2x"></i>
        <div>
            <strong>This product is Approved</strong><br>
            <small>
                Approved by <strong>{{ optional($product->approver)->name ?? 'Admin' }}</strong>
                @if($product->approved_at)
                    on {{ $product->approved_at->format('d M Y, h:i A') }}
                @endif
            </small>
        </div>
    </div>
    @endif

    {{-- If rejected --}}
    @if($product->status === 'rejected' && $product->rejection_reason)
    <div class="alert alert-danger d-flex align-items-start gap-3 mb-4 shadow-sm">
        <i class="fas fa-times-circle fa-2x mt-1"></i>
        <div>
            <strong>This product was Rejected</strong><br>
            <small class="d-block mt-1">Reason: {{ $product->rejection_reason }}</small>
        </div>
    </div>
    @endif

    <div class="row g-4">

        {{-- LEFT COLUMN --}}
        <div class="col-lg-5">

            {{-- Product Image Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-image me-2 text-muted"></i>Product Image</h6>
                    @if($product->image)
                        <img src="{{ asset('uploads/' . $product->image) }}"
                             alt="{{ $product->title }}"
                             class="img-fluid rounded"
                             style="width: 100%; max-height: 320px; object-fit: cover;">
                    @else
                        <div class="text-center text-muted py-5 bg-light rounded">
                            <i class="fas fa-image fa-4x mb-3"></i>
                            <p>No image uploaded</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Seller Information --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-store me-2 text-muted"></i>Seller Information</h6>

                    <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                        @if(optional($product->seller)->business_logo)
                            <img src="{{ asset('uploads/' . $product->seller->business_logo) }}"
                                 alt="Logo" width="48" height="48"
                                 class="rounded-circle border">
                        @else
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:48px;height:48px;">
                                <i class="fas fa-store text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <div class="fw-semibold">{{ optional($product->seller)->business_name ?? 'N/A' }}</div>
                            <small class="text-muted">{{ optional($product->seller)->owner_name ?? '' }}</small>
                        </div>
                    </div>

                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted ps-0" style="width:40%">EMAIL</td>
                            <td class="fw-semibold">{{ optional($product->seller)->email ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">PHONE</td>
                            <td class="fw-semibold">{{ optional($product->seller)->phone ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">GST NO.</td>
                            <td class="fw-semibold">{{ optional($product->seller)->gst_number ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">BUSINESS ADDR</td>
                            <td class="fw-semibold">{{ optional($product->seller)->business_address ?? '—' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Review Timeline --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-history me-2 text-muted"></i>Review Timeline</h6>

                    <div class="timeline">
                        {{-- Submitted --}}
                        <div class="d-flex gap-3 mb-3">
                            <div class="text-center" style="min-width:28px;">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                     style="width:28px;height:28px;">
                                    <i class="fas fa-paper-plane text-white" style="font-size:11px;"></i>
                                </div>
                                <div class="border-start ms-auto" style="height:24px;width:1px;margin-top:2px;margin-left:13px;border-color:#dee2e6!important;"></div>
                            </div>
                            <div>
                                <div class="fw-semibold" style="font-size:14px;">Product Submitted</div>
                                <small class="text-muted">{{ $product->created_at->format('d M Y, h:i A') }}</small>
                            </div>
                        </div>

                        {{-- Status event --}}
                        @if($product->status === 'approved' && $product->approved_at)
                        <div class="d-flex gap-3 mb-3">
                            <div class="text-center" style="min-width:28px;">
                                <div class="rounded-circle bg-success d-flex align-items-center justify-content-center"
                                     style="width:28px;height:28px;">
                                    <i class="fas fa-check text-white" style="font-size:11px;"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-semibold text-success" style="font-size:14px;">Product Approved</div>
                                <small class="text-muted">
                                    By {{ optional($product->approver)->name ?? 'Admin' }} &bull;
                                    {{ $product->approved_at->format('d M Y, h:i A') }}
                                </small>
                            </div>
                        </div>

                        @elseif($product->status === 'rejected')
                        <div class="d-flex gap-3 mb-3">
                            <div class="text-center" style="min-width:28px;">
                                <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center"
                                     style="width:28px;height:28px;">
                                    <i class="fas fa-times text-white" style="font-size:11px;"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-semibold text-danger" style="font-size:14px;">Product Rejected</div>
                                @if($product->rejection_reason)
                                <small class="text-muted">Reason: {{ Str::limit($product->rejection_reason, 80) }}</small>
                                @endif
                            </div>
                        </div>

                        @elseif($product->status === 'resubmitted')
                        <div class="d-flex gap-3 mb-3">
                            <div class="text-center" style="min-width:28px;">
                                <div class="rounded-circle bg-info d-flex align-items-center justify-content-center"
                                     style="width:28px;height:28px;">
                                    <i class="fas fa-redo text-white" style="font-size:11px;"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-semibold text-info" style="font-size:14px;">Product Resubmitted</div>
                                <small class="text-muted">Seller updated and resubmitted for review</small>
                            </div>
                        </div>

                        @else
                        {{-- Pending --}}
                        <div class="d-flex gap-3">
                            <div class="text-center" style="min-width:28px;">
                                <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center"
                                     style="width:28px;height:28px;">
                                    <i class="fas fa-clock text-dark" style="font-size:11px;"></i>
                                </div>
                            </div>
                            <div>
                                <div class="fw-semibold text-warning" style="font-size:14px;">Awaiting Admin Review</div>
                                <small class="text-muted">No decision has been made yet</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>{{-- /LEFT COLUMN --}}

        {{-- RIGHT COLUMN --}}
        <div class="col-lg-7">

            {{-- Product Details --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-tag me-2 text-muted"></i>Product Details</h6>

                    <h4 class="fw-bold mb-1">{{ $product->title }}</h4>
                    <small class="text-muted">Submitted on {{ $product->created_at->format('d M Y') }}</small>

                    <hr>

                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted ps-0" style="width:40%">CATEGORY</td>
                            <td class="fw-semibold">{{ optional($product->category)->name ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">BRAND</td>
                            <td class="fw-semibold">{{ optional($product->brand)->name ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">SELLING PRICE</td>
                            <td class="fw-bold text-success fs-5">₹{{ number_format($product->price, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">STOCK</td>
                            <td class="fw-semibold">
                                @if($product->quantity > 0)
                                    <span class="text-success">{{ $product->quantity }} units</span>
                                @else
                                    <span class="text-danger">Out of Stock</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">APPROVAL STATUS</td>
                            <td>
                                <span class="badge bg-{{ $sc }}">{{ $si }} {{ ucfirst($product->status) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Product Description --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-align-left me-2 text-muted"></i>Product Description</h6>
                    <div class="bg-light rounded p-3" style="min-height:80px;">
                        @if($product->description)
                            <p class="mb-0">{{ $product->description }}</p>
                        @else
                            <p class="text-muted mb-0 fst-italic">No description provided.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Product Variants --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold mb-0"><i class="fas fa-layer-group me-2 text-muted"></i>Product Variants</h6>
                        @if($product->variants->count() > 0)
                            <span class="badge bg-secondary">{{ $product->variants->count() }} variant{{ $product->variants->count() > 1 ? 's' : '' }}</span>
                        @endif
                    </div>

                    @if($product->variants->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>IMAGE</th>
                                    <th>COLOR</th>
                                    <th>SIZE &amp; PRICE</th>
                                    <th>STOCK</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->variants as $variant)
                                <tr>
                                    <td>
                                        @if($variant->image)
                                            <img src="{{ asset('uploads/variants/' . $variant->image) }}"
                                                 width="40" height="40"
                                                 style="object-fit:cover; border-radius:6px;"
                                                 alt="Variant">
                                        @elseif($variant->color && $variant->color->hex_code)
                                            <div style="width:40px;height:40px;background:{{ $variant->color->hex_code }};border-radius:6px;border:1px solid #dee2e6;"></div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($variant->color)
                                            <div class="d-flex align-items-center gap-2">
                                                @if($variant->color->hex_code)
                                                    <span class="rounded-circle border" style="width:14px;height:14px;background:{{ $variant->color->hex_code }};display:inline-block;"></span>
                                                @endif
                                                <small>{{ $variant->color->name }}</small>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($variant->size)
                                            <small class="text-muted d-block">{{ $variant->size->name }}</small>
                                        @endif
                                        <span class="fw-semibold">₹{{ number_format($variant->price, 2) }}</span>
                                    </td>
                                    <td>
                                        @if($variant->quantity > 0)
                                            <span class="text-success fw-semibold">{{ $variant->quantity }}</span>
                                        @else
                                            <span class="text-danger fw-semibold">0</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($variant->quantity > 0)
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Out of Stock</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <p class="text-muted fst-italic mb-0">No variants added for this product.</p>
                    @endif
                </div>
            </div>

        </div>{{-- /RIGHT COLUMN --}}

    </div>{{-- /row --}}

    {{-- Back button --}}
    <div class="d-flex justify-content-end mt-4 mb-4">
        <a href="{{ route('admin.products.approvals') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Product List
        </a>
    </div>

</div>{{-- /container --}}


{{-- Reject Modal --}}
@if(in_array($product->status, ['pending', 'resubmitted']))
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Reject Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.products.reject', $product->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="mb-3">
                        You are about to reject: <strong>{{ $product->title }}</strong>
                    </p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label fw-semibold">
                            Rejection Reason <span class="text-danger">*</span>
                        </label>
                        <textarea name="rejection_reason"
                                  id="rejection_reason"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Please provide a detailed reason for rejection (min 10 characters)..."
                                  required
                                  minlength="10"></textarea>
                        <div class="form-text text-muted">
                            The seller will see this reason and must address it before resubmitting.
                        </div>
                        @error('rejection_reason')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times-circle me-1"></i>Reject Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
