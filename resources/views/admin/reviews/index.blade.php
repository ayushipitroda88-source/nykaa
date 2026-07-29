@extends('layout.admin')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold"><i class="bi bi-star-half text-warning me-2"></i> Review Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Reviews</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Sub-Navigation Tabs -->
        <div class="card card-outline card-primary shadow-sm mb-4">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'pending' ? 'active' : '' }}" href="{{ route('admin.reviews.pending') }}">
                            <i class="bi bi-clock-history me-1"></i> Pending Reviews
                            <span class="badge bg-warning text-dark ms-1">{{ App\Models\Review::where('status', 'pending')->count() }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'approved' ? 'active' : '' }}" href="{{ route('admin.reviews.approved') }}">
                            <i class="bi bi-check-circle me-1"></i> Approved Reviews
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'rejected' ? 'active' : '' }}" href="{{ route('admin.reviews.rejected') }}">
                            <i class="bi bi-x-circle me-1"></i> Rejected Reviews
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $type === 'reported' ? 'active' : '' }}" href="{{ route('admin.reviews.reported') }}">
                            <i class="bi bi-flag me-1"></i> Reported Reviews
                            <span class="badge bg-danger ms-1">{{ App\Models\ReviewReport::where('status', 'pending')->count() }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0">
                @if($type === 'reported')
                    <!-- Reported Reviews Table -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Reported By</th>
                                    <th>Reason</th>
                                    <th>Details</th>
                                    <th>Review Content</th>
                                    <th>Product</th>
                                    <th>Report Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $rep)
                                    <tr>
                                        <td>
                                            <div class="fw-bold">{{ $rep->user->name ?? 'User' }}</div>
                                            <small class="text-muted">{{ $rep->user->email ?? '' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger text-uppercase">{{ str_replace('_', ' ', $rep->reason) }}</span>
                                        </td>
                                        <td>
                                            <small class="text-secondary">{{ $rep->details ?? 'N/A' }}</small>
                                        </td>
                                        <td style="max-width:250px;">
                                            <div class="fw-bold text-dark text-truncate">{{ $rep->review->title ?? 'N/A' }}</div>
                                            <small class="text-muted d-block text-truncate">{{ $rep->review->description ?? '' }}</small>
                                        </td>
                                        <td>
                                            @if(isset($rep->review->product))
                                                <a href="{{ route('product.show', $rep->review->product->id) }}" target="_blank" class="fw-bold text-primary">
                                                    {{ Str::limit($rep->review->product->title, 25) }}
                                                </a>
                                            @endif
                                        </td>
                                        <td><small class="text-muted">{{ $rep->created_at->format('d M Y') }}</small></td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <form action="{{ route('admin.reviews.dismiss-report', $rep->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-secondary" title="Dismiss Report">
                                                        <i class="bi bi-shield-slash"></i> Dismiss
                                                    </button>
                                                </form>

                                                @if(isset($rep->review))
                                                    <form action="{{ route('admin.reviews.destroy', $rep->review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this reported review?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Delete Review">
                                                            <i class="bi bi-trash"></i> Delete Review
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">No pending review reports.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Reviews Table (Pending, Approved, Rejected) -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Review Content</th>
                                    <th>Images</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $rev)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2" style="max-width: 220px;">
                                                @if($rev->product && $rev->product->image)
                                                    <img src="{{ asset('uploads/' . $rev->product->image) }}" width="45" height="45" class="rounded object-fit-cover flex-shrink-0">
                                                @endif
                                                <div class="text-truncate">
                                                    @if($rev->product)
                                                        <a href="{{ route('product.show', $rev->product->id) }}" target="_blank" class="fw-bold text-dark text-truncate d-block" title="{{ $rev->product->title }}">
                                                            {{ $rev->product->title }}
                                                        </a>
                                                        <small class="text-muted d-block">Seller: {{ $rev->product->seller->business_name ?? 'Admin' }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $rev->user->name ?? 'User' }}</div>
                                            <small class="text-muted d-block">{{ $rev->user->email ?? '' }}</small>
                                            @if($rev->is_verified_purchase)
                                                <span class="badge bg-success-subtle text-success small" style="font-size:10px;">✔ Verified</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark fw-bold fs-6">
                                                ★ {{ $rev->rating }}.0
                                            </span>
                                        </td>
                                        <td style="max-width: 280px;">
                                            <div class="fw-bold text-dark text-truncate">{{ $rev->title }}</div>
                                            <small class="text-muted d-block text-truncate" title="{{ $rev->description }}">{{ $rev->description }}</small>
                                            @if($rev->status === 'rejected' && $rev->rejection_reason)
                                                <div class="small text-danger mt-1"><strong>Reason:</strong> {{ $rev->rejection_reason }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($rev->images->count() > 0)
                                                <div class="d-flex gap-1">
                                                    @foreach($rev->images as $img)
                                                        <a href="{{ asset('uploads/' . $img->image_path) }}" target="_blank">
                                                            <img src="{{ asset('uploads/' . $img->image_path) }}" width="35" height="35" class="rounded border" style="object-fit:cover;">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-muted small">No images</span>
                                            @endif
                                        </td>
                                        <td><small class="text-muted">{{ $rev->created_at->format('d M Y') }}</small></td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                @if($rev->status !== 'approved')
                                                    <form action="{{ route('admin.reviews.approve', $rev->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success" title="Approve Review">
                                                            <i class="bi bi-check-lg"></i> Approve
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($rev->status !== 'rejected')
                                                    <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $rev->id }}" title="Reject Review">
                                                        <i class="bi bi-x-lg"></i> Reject
                                                    </button>
                                                @endif

                                                <form action="{{ route('admin.reviews.destroy', $rev->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Delete Review">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>

                                            <!-- Rejection Modal -->
                                            @if($rev->status !== 'rejected')
                                                <div class="modal fade text-start" id="rejectModal-{{ $rev->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content border-0 shadow">
                                                            <div class="modal-header bg-warning text-dark">
                                                                <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Reject Review</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="{{ route('admin.reviews.reject', $rev->id) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body p-4">
                                                                    <p class="small text-muted mb-3">Please specify the reason for rejecting this review. The customer will see this message in their account profile.</p>
                                                                    <div class="mb-3">
                                                                        <label class="form-label fw-bold">Rejection Reason <span class="text-danger">*</span></label>
                                                                        <textarea name="rejection_reason" class="form-control" rows="3" placeholder="e.g. Contains offensive language, irrelevant content, or inappropriate promotion..." required></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer bg-light border-0">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-danger fw-bold">Confirm Rejection</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">No {{ $type }} reviews found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @if(isset($reviews) && $reviews->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                    {{ $reviews->links() }}
                </div>
            @endif

            @if(isset($reports) && $reports->hasPages())
                <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                    {{ $reports->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
