@extends('user.index')

@section('title', 'Order Details - NYKAA')

@push('page-styles')
<style>
.order-details-page {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
    font-family: 'Inter', sans-serif;
}
.order-header-box {
    background: #fff;
    border: 1px solid #eee;
    border-radius: 12px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
}
.badge-status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
}
.badge-pending { background: #fff3cd; color: #856404; }
.badge-confirmed { background: #d4edda; color: #155724; }
.badge-delivered { background: #d4edda; color: #155724; }
.badge-cancelled { background: #f8d7da; color: #721c24; }

.btn-write-review {
    background: #fff;
    color: #fc2779;
    border: 2px solid #fc2779;
    padding: 6px 16px;
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
}
.btn-confirm-order {
    background: linear-gradient(135deg, #28a745, #218838);
    color: #fff;
    border: none;
    padding: 10px 22px;
    border-radius: 30px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(40,167,69,.2);
    transition: all .25s;
}
.btn-confirm-order:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    transform: translateY(-1px);
    color: #fff;
}
</style>
@endpush

@section('content')
<div class="order-details-page">
    <a href="{{ route('user.orders.index') }}" class="btn btn-link text-decoration-none text-dark fw-bold mb-3">
        &larr; Back to My Orders
    </a>

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
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @php
        $isConfirmed = strtolower($order->status) === 'confirmed';
        $isCancelled = strtolower($order->status) === 'cancelled';
    @endphp

    <div class="order-header-box">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-1">Order #ORDER-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                <div class="text-muted small">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge-status badge-{{ strtolower($order->status) }}">
                    {{ ucfirst($order->status) }}
                    @if($isConfirmed) ✅ @endif
                </span>

                @if(!$isConfirmed && !$isCancelled)
                    <button type="button" class="btn-confirm-order"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmOrderModal-{{ $order->id }}">
                        📦 Confirm Order
                    </button>

                    <div class="modal fade" id="confirmOrderModal-{{ $order->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title fw-bold">📦 Order Confirmation</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body text-center py-4">
                                    <div class="display-4 text-success mb-3"><i class="bi bi-box-seam"></i></div>
                                    <h5 class="fw-bold mb-2">Have you received this order?</h5>
                                    <p class="text-muted small mb-0">Once confirmed, you can submit ratings & reviews.</p>
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

        <hr class="my-4">

        <div class="row g-4">
            <div class="col-md-6">
                <h6 class="fw-bold text-uppercase text-muted small">Shipping Address</h6>
                <p class="mb-0 text-dark font-weight-medium">{{ $order->shipping_address }}</p>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold text-uppercase text-muted small">Payment Details</h6>
                <p class="mb-0 text-dark">Method: <strong class="text-uppercase">{{ $order->payment_method ?? 'COD' }}</strong></p>
                <p class="mb-0 text-dark">Status: <span class="badge bg-secondary">{{ ucfirst($order->payment_status ?? 'pending') }}</span></p>
            </div>
        </div>

        @if($isConfirmed && $order->confirmed_at)
            <div class="mt-3 p-2 bg-light rounded-2">
                <small class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Confirmed on {{ $order->confirmed_at->format('d M Y, h:i A') }}</small>
            </div>
        @endif
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">Order Items</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="text-end">Total</th>
                            <th>Review</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            @php $userReview = $item->product ? $item->product->reviews->first() : null; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('uploads/' . $item->product->image) }}" width="60" height="60" class="rounded object-fit-cover">
                                        @endif
                                        <div>
                                            @if($item->product)
                                                <a href="{{ route('product.show', $item->product->id) }}" class="fw-bold text-dark text-decoration-none">
                                                    {{ $item->product->title }}
                                                </a>
                                            @else
                                                <span class="text-muted">Product unavailable</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>&#8377;{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end fw-bold">&#8377;{{ number_format($item->price * $item->quantity, 2) }}</td>
                                <td>
                                    @if($isConfirmed && $item->product)
                                        <button type="button"
                                                class="btn-write-review"
                                                data-bs-toggle="modal"
                                                data-bs-target="#reviewModal-{{ $item->product->id }}">
                                            @if($userReview)
                                                <i class="bi bi-pencil-square"></i> Edit Review
                                            @else
                                                ⭐ Write Review
                                            @endif
                                        </button>
                                        @include('user.partials.review-modal', ['product' => $item->product, 'review' => $userReview])
                                    @elseif(!$isConfirmed && $item->product)
                                        <small class="text-muted"><i class="bi bi-lock me-1"></i> Confirm order first</small>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
