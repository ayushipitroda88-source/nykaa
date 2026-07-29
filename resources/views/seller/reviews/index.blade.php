@extends('layout.seller')

@section('page-title', 'Product Reviews')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fas fa-star text-warning me-2"></i> Product Reviews & Ratings</h4>
            <p class="text-muted small mb-0">View customer ratings and respond to reviews for your products.</p>
        </div>
    </div>

    <!-- Analytics Stats Overview -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-3 p-4 bg-white text-center h-100">
                <div class="text-muted small fw-bold text-uppercase mb-2">Average Store Rating</div>
                <div class="display-4 fw-bold text-dark">{{ number_format($stats->average_rating, 1) }}</div>
                <div class="fs-5 text-warning my-1">
                    @php $avg = round($stats->average_rating); @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $avg) ★ @else <span class="text-muted opacity-25">★</span> @endif
                    @endfor
                </div>
                <div class="text-muted small">From {{ $stats->total_reviews }} approved customer reviews</div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                <div class="text-muted small fw-bold text-uppercase mb-3">Rating Breakdown</div>
                @foreach($ratingBreakdown as $star => $data)
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="fw-bold text-dark" style="width: 50px; font-size: 13px;">{{ $star }} Star</div>
                        <div class="progress flex-grow-1" style="height: 8px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $data['percentage'] }}%"></div>
                        </div>
                        <div class="text-muted small text-end" style="width: 45px;">{{ $data['count'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Reviews Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="fw-bold mb-0 text-dark">Customer Reviews List</h6>
            
            <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('seller.reviews.index', ['status' => 'all']) }}" class="btn {{ $statusFilter === 'all' ? 'btn-dark' : 'btn-outline-secondary' }}">All</a>
                <a href="{{ route('seller.reviews.index', ['status' => 'approved']) }}" class="btn {{ $statusFilter === 'approved' ? 'btn-success' : 'btn-outline-secondary' }}">Approved</a>
                <a href="{{ route('seller.reviews.index', ['status' => 'pending']) }}" class="btn {{ $statusFilter === 'pending' ? 'btn-warning' : 'btn-outline-secondary' }}">Pending</a>
                <a href="{{ route('seller.reviews.index', ['status' => 'rejected']) }}" class="btn {{ $statusFilter === 'rejected' ? 'btn-danger' : 'btn-outline-secondary' }}">Rejected</a>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Review Title & Details</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Action</th>
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
                                            <span class="fw-bold text-dark d-block text-truncate" title="{{ $rev->product->title ?? '' }}">
                                                {{ $rev->product->title ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $rev->user->name ?? 'User' }}</div>
                                    @if($rev->is_verified_purchase)
                                        <span class="badge bg-success-subtle text-success small" style="font-size:10px;">✔ Verified Purchase</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-warning text-dark px-2 py-1 fs-6">
                                        ★ {{ $rev->rating }}.0
                                    </span>
                                </td>
                                <td style="max-width: 300px;">
                                    <div class="fw-bold text-dark text-truncate">{{ $rev->title }}</div>
                                    <small class="text-muted d-block text-truncate">{{ $rev->description }}</small>
                                    @if($rev->images->count() > 0)
                                        <div class="d-flex gap-1 mt-1">
                                            @foreach($rev->images as $img)
                                                <img src="{{ asset('uploads/' . $img->image_path) }}" width="30" height="30" class="rounded border" style="object-fit:cover;">
                                            @endforeach
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($rev->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($rev->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $rev->created_at->format('d M Y') }}</small>
                                </td>
                                <td class="text-end">
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-primary rounded-pill fw-bold"
                                            data-bs-toggle="modal"
                                            data-bs-target="#replyModal-{{ $rev->id }}">
                                        <i class="fas fa-reply me-1"></i> {{ $rev->reply ? 'Edit Reply' : 'Reply' }}
                                    </button>

                                    <!-- Seller Reply Modal -->
                                    <div class="modal fade text-start" id="replyModal-{{ $rev->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-dark text-white">
                                                    <h5 class="modal-title fw-bold"><i class="fas fa-reply me-2"></i> Reply to Customer Review</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>

                                                <form action="{{ route('seller.reviews.reply', $rev->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body p-4">
                                                        <div class="p-3 bg-light rounded mb-3">
                                                            <div class="fw-bold text-dark">Review by {{ $rev->user->name ?? 'User' }} (★ {{ $rev->rating }}.0)</div>
                                                            <div class="small text-muted">{{ $rev->title }}</div>
                                                            <div class="small text-secondary mt-1">"{{ $rev->description }}"</div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-bold">Your Response <span class="text-danger">*</span></label>
                                                            <textarea name="reply" class="form-control" rows="4" placeholder="Write a polite response to your customer..." required minlength="5">{{ old('reply', $rev->reply->reply ?? '') }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer bg-light border-0">
                                                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary px-4 fw-bold">Post Reply</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-star-half-alt fa-2x mb-2 d-block text-secondary opacity-50"></i>
                                    No product reviews found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($reviews->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
