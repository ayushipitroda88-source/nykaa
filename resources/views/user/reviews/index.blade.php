@extends('user.index')

@section('title', 'My Reviews - NYKAA')

@push('page-styles')
<style>
.my-reviews-page {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: 'Inter', sans-serif;
}
.page-heading {
    font-size: 28px;
    font-weight: 800;
    color: #111;
    margin-bottom: 25px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 12px;
}
.review-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 20px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
}
.badge-pending { background: #fff3cd; color: #856404; font-weight: 700; }
.badge-approved { background: #d4edda; color: #155724; font-weight: 700; }
.badge-rejected { background: #f8d7da; color: #721c24; font-weight: 700; }

.star-rating { color: #ffb400; font-size: 18px; }
.review-title-text { font-size: 18px; font-weight: 700; color: #222; margin-top: 6px; }
.review-desc-text { color: #555; line-height: 1.6; margin-top: 8px; }

.rejection-alert {
    background: #fff5f5;
    border-left: 4px solid #dc3545;
    padding: 12px 16px;
    border-radius: 6px;
    margin-top: 15px;
    font-size: 13.5px;
    color: #721c24;
}
.seller-reply-box {
    background: #f8f9fa;
    border-left: 3px solid #fc2779;
    padding: 14px 18px;
    border-radius: 8px;
    margin-top: 15px;
    font-size: 14px;
}
</style>
@endpush

@section('content')
<div class="my-reviews-page">
    <h1 class="page-heading"><i class="bi bi-star me-2" style="color:#fc2779;"></i> My Reviews</h1>

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

    @forelse($reviews as $review)
        <div class="review-card">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div class="d-flex gap-3 align-items-center">
                    @if($review->product && $review->product->image)
                        <img src="{{ asset('uploads/' . $review->product->image) }}" width="60" height="60" class="rounded object-fit-cover">
                    @endif
                    <div>
                        @if($review->product)
                            <a href="{{ route('product.show', $review->product->id) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $review->product->title }}
                            </a>
                        @endif
                        <div class="text-muted small">Reviewed on {{ $review->created_at->format('d M Y') }}</div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge badge-{{ strtolower($review->status) }} px-3 py-2 rounded-pill text-uppercase">
                        <i class="bi bi-circle-fill me-1" style="font-size:8px;"></i> {{ ucfirst($review->status) }}
                    </span>

                    <button type="button" 
                            class="btn btn-outline-secondary btn-sm rounded-pill fw-bold"
                            data-bs-toggle="modal"
                            data-bs-target="#reviewModal-{{ $review->product_id }}">
                        <i class="bi bi-pencil"></i> Edit
                    </button>

                    <form action="{{ route('user.reviews.destroy', $review->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill fw-bold">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                    </form>

                    @include('user.partials.review-modal', ['product' => $review->product, 'review' => $review])
                </div>
            </div>

            <hr class="my-3">

            <div class="star-rating">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $review->rating)
                        ★
                    @else
                        <span style="color:#ddd;">★</span>
                    @endif
                @endfor
                <span class="ms-2 fw-bold text-dark fs-6">{{ $review->rating }}.0</span>
            </div>

            <div class="review-title-text">{{ $review->title }}</div>
            <div class="review-desc-text">{{ $review->description }}</div>

            @if($review->images->count() > 0)
                <div class="d-flex gap-2 flex-wrap mt-3">
                    @foreach($review->images as $img)
                        <img src="{{ asset('uploads/' . $img->image_path) }}" width="70" height="70" class="rounded border" style="object-fit:cover;">
                    @endforeach
                </div>
            @endif

            @if($review->status === 'rejected' && $review->rejection_reason)
                <div class="rejection-alert">
                    <strong><i class="bi bi-exclamation-octagon-fill me-1"></i> Rejection Reason:</strong>
                    {{ $review->rejection_reason }}
                    <div class="small mt-1 text-muted">You can edit your review and resubmit it for moderation.</div>
                </div>
            @endif

            @if($review->reply)
                <div class="seller-reply-box">
                    <div class="fw-bold text-dark mb-1">
                        <i class="bi bi-reply-fill me-1" style="color:#fc2779;"></i> Response from Seller ({{ $review->reply->seller->business_name ?? 'Seller' }}):
                    </div>
                    <div class="text-muted small mb-1">{{ $review->reply->created_at->format('d M Y') }}</div>
                    <div>{{ $review->reply->reply }}</div>
                </div>
            @endif
        </div>
    @empty
        <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
            <div class="display-1 text-muted mb-3"><i class="bi bi-star"></i></div>
            <h4 class="fw-bold text-dark">No Reviews Found</h4>
            <p class="text-muted">You haven't reviewed any products yet.</p>
            <a href="{{ route('user.orders.index') }}" class="btn text-white fw-bold px-4 py-2 mt-2 rounded-pill" style="background:#fc2779;">View My Orders</a>
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $reviews->links() }}
    </div>
</div>
@endsection
