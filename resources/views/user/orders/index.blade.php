@extends('user.index')

@section('title', 'My Orders - NYKAA')

@push('page-styles')
<style>
.orders-page {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: 'Inter', sans-serif;
}
.orders-title {
    font-size: 28px;
    font-weight: 800;
    color: #111;
    margin-bottom: 25px;
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 12px;
}
.order-card {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.order-card:hover {
    box-shadow: 0 6px 20px rgba(0,0,0,0.07);
}
.order-header {
    background: #fafafa;
    padding: 16px 24px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}
.order-info-item {
    font-size: 13px;
    color: #666;
}
.order-info-item strong {
    color: #222;
    font-size: 14px;
    display: block;
    margin-top: 2px;
}
.order-body {
    padding: 24px;
}
.order-item-row {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 15px 0;
    border-bottom: 1px solid #f8f8f8;
}
.order-item-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}
.order-item-img {
    width: 80px;
    height: 90px;
    object-fit: contain;
    background: #f9f9f9;
    border-radius: 8px;
    padding: 6px;
    border: 1px solid #eee;
    flex-shrink: 0;
}
.order-item-details {
    flex: 1;
}
.order-item-title {
    font-size: 16px;
    font-weight: 700;
    color: #222;
    text-decoration: none;
    transition: color 0.2s;
}
.order-item-title:hover {
    color: #fc2779;
}
.order-item-meta {
    font-size: 13px;
    color: #777;
    margin-top: 4px;
}
.order-item-price {
    font-size: 16px;
    font-weight: 700;
    color: #fc2779;
    margin-top: 6px;
}
.order-actions {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
    flex-shrink: 0;
}
.btn-confirm-order {
    background: linear-gradient(135deg, #28a745, #218838);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 30px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
}
.btn-confirm-order:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(40, 167, 69, 0.3);
    color: #fff;
}
.btn-write-review {
    background: #fff;
    color: #fc2779;
    border: 2px solid #fc2779;
    padding: 8px 18px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}
.btn-write-review:hover {
    background: #fc2779;
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(252, 39, 121, 0.25);
}
.btn-edit-review {
    background: #fff;
    color: #ff9800;
    border: 2px solid #ff9800;
    padding: 8px 18px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}
.btn-edit-review:hover {
    background: #ff9800;
    color: #fff;
}
.btn-delete-review {
    background: none;
    color: #dc3545;
    border: none;
    padding: 6px 10px;
    border-radius: 30px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.btn-delete-review:hover {
    background: #fdecea;
}
.badge-status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.badge-pending { background: #fff3cd; color: #856404; }
.badge-processing { background: #cce5ff; color: #004085; }
.badge-confirmed { background: #d4edda; color: #155724; }
.badge-delivered { background: #d4edda; color: #155724; }
.badge-cancelled { background: #f8d7da; color: #721c24; }

/* Existing review display under each order item */
.existing-review-card {
    margin-top: 10px;
    padding: 12px 16px;
    background: #f8f9fb;
    border-radius: 10px;
    border: 1px solid #eee;
}
.existing-review-card .review-stars {
    color: #ffb400;
    font-size: 14px;
}
.existing-review-card .review-title {
    font-weight: 700;
    color: #333;
    font-size: 14px;
    margin: 4px 0;
}
.existing-review-card .review-text {
    color: #666;
    font-size: 13px;
    line-height: 1.5;
}

/* Star Rating Radio styling in Modal */
.star-rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 6px;
    font-size: 28px;
    margin: 10px 0;
}
.star-rating-input input { display: none; }
.star-rating-input label {
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}
.star-rating-input input:checked ~ label,
.star-rating-input label:hover,
.star-rating-input label:hover ~ label {
    color: #ffb400;
}
</style>
@endpush

@section('content')
<div class="orders-page">
    <h1 class="orders-title"><i class="bi bi-bag-check me-2" style="color:#fc2779;"></i> My Orders</h1>

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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @forelse($orders as $order)
        @php
            $isConfirmed = strtolower($order->status) === 'confirmed';
            $isCancelled = strtolower($order->status) === 'cancelled';
        @endphp
        <div class="order-card">
            <div class="order-header">
                <div class="d-flex gap-4 flex-wrap align-items-center">
                    <div class="order-info-item">
                        ORDER PLACED
                        <strong>{{ $order->created_at->format('d M Y, h:i A') }}</strong>
                    </div>
                    <div class="order-info-item">
                        TOTAL
                        <strong>&#8377;{{ number_format($order->total_amount, 2) }}</strong>
                    </div>
                    <div class="order-info-item">
                        ORDER #
                        <strong>ORDER-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge-status badge-{{ strtolower($order->status) }}">
                        {{ ucfirst($order->status) }}
                        @if($isConfirmed) ✅ @endif
                    </span>

                    @if(!$isConfirmed && !$isCancelled)
                        <!-- 📦 Confirm Order Button -->
                        <button type="button"
                                class="btn-confirm-order"
                                data-bs-toggle="modal"
                                data-bs-target="#confirmOrderModal-{{ $order->id }}">
                            📦 Confirm Order
                        </button>

                        <!-- Confirm Order Modal -->
                        <div class="modal fade" id="confirmOrderModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-light">
                                        <h5 class="modal-title fw-bold text-dark">📦 Order Confirmation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center py-4">
                                        <div class="display-4 text-success mb-3"><i class="bi bi-box-seam"></i></div>
                                        <h5 class="fw-bold mb-2">Have you received this order?</h5>
                                        <p class="text-muted small mb-0">Once confirmed, your order status will be updated and you can submit ratings & reviews for your items.</p>
                                    </div>
                                    <div class="modal-footer justify-content-center bg-light border-0">
                                        <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('user.orders.confirm-order', $order->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold">Yes, Confirm Order</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="order-body">
            @foreach($order->items as $item)
                    @php
                        // reviews is eager-loaded filtered by user_id in UserOrderController
                        $userReview = ($item->product && $item->product->reviews->count())
                                        ? $item->product->reviews->first()
                                        : null;
                    @endphp
                    <div class="order-item-row">
                        @if($item->product && $item->product->image)
                            <img src="{{ asset('uploads/' . $item->product->image) }}" alt="{{ $item->product->title }}" class="order-item-img">
                        @else
                            <img src="https://placehold.co/80x90?text=No+Image" class="order-item-img" alt="No Image">
                        @endif

                        <div class="order-item-details">
                            @if($item->product)
                                <a href="{{ route('product.show', $item->product->id) }}" class="order-item-title">
                                    {{ $item->product->title }}
                                </a>
                            @else
                                <span class="order-item-title text-muted">Product no longer available</span>
                            @endif

                            <div class="order-item-meta">
                                Qty: {{ $item->quantity }} | Price: &#8377;{{ number_format($item->price, 2) }}
                            </div>
                            <div class="order-item-price">
                                &#8377;{{ number_format($item->price * $item->quantity, 2) }}
                            </div>

                            {{-- Show existing review inline --}}
                            @if($userReview)
                                <div class="existing-review-card">
                                    <div class="review-stars">
                                        @for($s=1; $s<=5; $s++)
                                            <i class="bi {{ $s <= $userReview->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                        <span style="color:#888;font-size:12px;margin-left:6px;">{{ $userReview->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if($userReview->title)
                                        <div class="review-title">{{ $userReview->title }}</div>
                                    @endif
                                    <div class="review-text">{{ Str::limit($userReview->description, 120) }}</div>
                                </div>
                            @endif

                            {{-- Review unlock hint for non-confirmed orders --}}
                            @if(!$isConfirmed && !$userReview && $item->product)
                                <div class="mt-2">
                                    <small class="text-muted" style="font-size:12px;">
                                        <i class="bi bi-star me-1" style="color:#ffb400;"></i>
                                        Confirm your order above to rate &amp; review this product
                                    </small>
                                </div>
                            @endif
                        </div>

                        <div class="order-actions">
                            @if($isConfirmed && $item->product)
                                @if($userReview)
                                    <button type="button"
                                            class="btn-edit-review"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reviewModal-{{ $item->product->id }}">
                                        <i class="bi bi-pencil-square"></i> Edit Review
                                    </button>
                                    <form action="{{ route('user.reviews.destroy', $userReview->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete-review">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                @else
                                    <button type="button"
                                            class="btn-write-review"
                                            data-bs-toggle="modal"
                                            data-bs-target="#reviewModal-{{ $item->product->id }}">
                                        ⭐ Write Review
                                    </button>
                                @endif

                                <!-- Review Modal for Product -->
                                @include('user.partials.review-modal', ['product' => $item->product, 'review' => $userReview])
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
            <div class="display-1 text-muted mb-3"><i class="bi bi-bag-x"></i></div>
            <h4 class="fw-bold text-dark">No Orders Found</h4>
            <p class="text-muted">You haven't placed any orders yet.</p>
            <a href="{{ url('/') }}" class="btn text-white fw-bold px-4 py-2 mt-2 rounded-pill" style="background:#fc2779;">Start Shopping</a>
        </div>
    @endforelse

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
