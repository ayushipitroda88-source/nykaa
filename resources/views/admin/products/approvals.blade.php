@extends('layout.admin')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="mb-4">📋 Product Approvals</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs mb-3" id="approvalTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.products.approvals', ['tab' => 'all']) }}"
               class="nav-link {{ $tab == 'all' ? 'active' : '' }}">
                All <span class="badge bg-secondary ms-1">{{ $counts['all'] }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.products.approvals', ['tab' => 'pending']) }}"
               class="nav-link {{ $tab == 'pending' ? 'active' : '' }}">
                Pending <span class="badge bg-warning text-dark ms-1">{{ $counts['pending'] }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.products.approvals', ['tab' => 'resubmitted']) }}"
               class="nav-link {{ $tab == 'resubmitted' ? 'active' : '' }}">
                Resubmitted <span class="badge bg-info text-dark ms-1">{{ $counts['resubmitted'] }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.products.approvals', ['tab' => 'approved']) }}"
               class="nav-link {{ $tab == 'approved' ? 'active' : '' }}">
                Approved <span class="badge bg-success ms-1">{{ $counts['approved'] }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.products.approvals', ['tab' => 'rejected']) }}"
               class="nav-link {{ $tab == 'rejected' ? 'active' : '' }}">
                Rejected <span class="badge bg-danger ms-1">{{ $counts['rejected'] }}</span>
            </a>
        </li>
    </ul>

    {{-- Products Table --}}
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Seller</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            {{-- Product Image --}}
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('uploads/' . $product->image) }}"
                                         alt="{{ $product->title }}"
                                         width="60" height="60"
                                         style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted"><i class="fas fa-image fa-2x"></i></span>
                                @endif
                            </td>

                            {{-- Product Name --}}
                            <td>
                                <strong>{{ $product->title }}</strong>
                                <br>
                                <small class="text-muted">ID: #{{ $product->id }}</small>
                            </td>

                            {{-- Seller --}}
                            <td>
                                <span class="fw-semibold">{{ optional($product->seller)->business_name ?? 'N/A' }}</span>
                                <br>
                                <small class="text-muted">{{ optional($product->seller)->email ?? '' }}</small>
                            </td>

                            {{-- Brand --}}
                            <td>{{ optional($product->brand)->name ?? 'N/A' }}</td>

                            {{-- Category --}}
                            <td>{{ optional($product->category)->name ?? 'N/A' }}</td>

                            {{-- Price --}}
                            <td>₹{{ number_format($product->price, 2) }}</td>

                            {{-- Status Badge --}}
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-warning text-dark',
                                        'resubmitted' => 'bg-info text-dark',
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                    ];
                                    $color = $statusColors[$product->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $color }}">{{ ucfirst($product->status) }}</span>

                                {{-- Show rejection reason for rejected products --}}
                                @if($product->status == 'rejected' && $product->rejection_reason)
                                    <br>
                                    <small class="text-danger" data-bs-toggle="tooltip" title="{{ $product->rejection_reason }}">
                                        <i class="fas fa-info-circle"></i> Reason available
                                    </small>
                                @endif

                                {{-- Show approval info for approved products --}}
                                @if($product->status == 'approved' && $product->approved_at)
                                    <br>
                                    <small class="text-success">
                                        <i class="fas fa-check"></i> {{ optional($product->approver)->name ?? 'Admin' }}
                                        <br>
                                        {{ $product->approved_at->format('d M Y, h:i A') }}
                                    </small>
                                @endif
                            </td>

                            {{-- Created Date --}}
                            <td>
                                <small class="text-muted">
                                    {{ $product->created_at->format('d M Y') }}
                                    <br>
                                    {{ $product->created_at->format('h:i A') }}
                                </small>
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    {{-- View Product --}}
                                    <a href="{{ route('admin.products.review', $product->id) }}"
                                       class="btn btn-outline-info"
                                       title="View Product">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Approve --}}
                                    @if(in_array($product->status, ['pending', 'resubmitted']))
                                    <form action="{{ route('admin.products.approve', $product->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to approve this product?');">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Reject (only for non-rejected products) --}}
                                    @if(!in_array($product->status, ['rejected', 'approved']))
                                    <button type="button"
                                            class="btn btn-outline-danger"
                                            title="Reject"
                                            data-bs-toggle="modal"
                                            data-bs-target="#rejectModal"
                                            data-product-id="{{ $product->id }}"
                                            data-product-title="{{ $product->title }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted mb-0">No products found in this tab.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Reject Product
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="mb-3">
                        You are about to reject: <strong id="rejectProductTitle"></strong>
                    </p>
                    <div class="mb-3">
                        <label for="rejection_reason" class="form-label fw-semibold">
                            Rejection Reason <span class="text-danger">*</span>
                        </label>
                        <textarea name="rejection_reason"
                                  id="rejection_reason"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Please provide detailed reason for rejection (min 10 characters)..."
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
                        <i class="fas fa-times-circle me-1"></i> Reject Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handle Reject Modal - set the form action dynamically
    document.addEventListener('DOMContentLoaded', function () {
        const rejectModal = document.getElementById('rejectModal');
        if (rejectModal) {
            rejectModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const productId = button.getAttribute('data-product-id');
                const productTitle = button.getAttribute('data-product-title');

                // Update modal content
                document.getElementById('rejectProductTitle').textContent = productTitle;
                document.getElementById('rejectForm').action = '{{ url('admin/products/approvals') }}/' + productId + '/reject';
            });
        }

        // Enable tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el);
        });
    });
</script>
@endpush