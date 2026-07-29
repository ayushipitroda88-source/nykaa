@extends('layout.seller')

@section('page-title', 'Order Details')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="seller-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0" style="color:var(--nykaa-dark);">
                    <i class="fas fa-receipt me-2" style="color:var(--nykaa-pink);"></i>
                    Order Details #{{ $orderItem->order_id }}
                </h4>
                <a href="{{ route('seller.orders.index') }}" class="btn-action">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </a>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#FAFAFE;border:1px solid var(--nykaa-border);">
                        <h6 class="fw-bold mb-3" style="color:var(--nykaa-dark);border-bottom:2px solid var(--nykaa-border);padding-bottom:8px;">
                            <i class="fas fa-user me-2" style="color:var(--nykaa-pink);"></i>Customer Information
                        </h6>
                        <div class="mb-2"><span class="text-muted">Name:</span> <strong>{{ $orderItem->order->user->name ?? 'Unknown' }}</strong></div>
                        <div class="mb-2"><span class="text-muted">Email:</span> <strong>{{ $orderItem->order->user->email ?? 'N/A' }}</strong></div>
                        <div class="mb-2"><span class="text-muted">Phone:</span> <strong>{{ $orderItem->order->user->phone ?? 'N/A' }}</strong></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 rounded" style="background:#FAFAFE;border:1px solid var(--nykaa-border);">
                        <h6 class="fw-bold mb-3" style="color:var(--nykaa-dark);border-bottom:2px solid var(--nykaa-border);padding-bottom:8px;">
                            <i class="fas fa-info-circle me-2" style="color:var(--nykaa-pink);"></i>Order Information
                        </h6>
                        <div class="mb-2"><span class="text-muted">Order Date:</span> <strong>{{ $orderItem->created_at->format('d M Y, h:i A') }}</strong></div>
                        <div class="mb-2">
                            <span class="text-muted">Status:</span>
                            @php
                                $status = $orderItem->order->status ?? 'pending';
                                $badgeClass = match($status) {
                                    'completed' => 'bg-approved',
                                    'cancelled' => 'bg-rejected',
                                    'pending' => 'bg-pending',
                                    default => 'bg-pending'
                                };
                            @endphp
                            <span class="badge-nykaa {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">Payment:</span>
                            <strong>{{ strtoupper($orderItem->order->payment_method ?? 'N/A') }}</strong>
                            @php
                                $payStatus = $orderItem->order->payment_status ?? 'pending';
                                $payBadge = $payStatus == 'paid' ? 'bg-approved' : 'bg-pending';
                            @endphp
                            <span class="badge-nykaa {{ $payBadge }} ms-1">{{ ucfirst($payStatus) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold mb-2" style="color:var(--nykaa-dark);">
                    <i class="fas fa-map-marker-alt me-2" style="color:var(--nykaa-pink);"></i>Shipping Address
                </h6>
                <div class="p-3 rounded" style="background:#FAFAFE;border:1px solid var(--nykaa-border);">
                    {{ $orderItem->order->shipping_address ?? 'No shipping address provided.' }}
                </div>
            </div>

            <div>
                <h6 class="fw-bold mb-3" style="color:var(--nykaa-dark);">
                    <i class="fas fa-box me-2" style="color:var(--nykaa-pink);"></i>Product Details
                </h6>
                <div class="d-flex align-items-center p-4 rounded" style="background:#FAFAFE;border:1px solid var(--nykaa-border);">
                    @if($orderItem->product)
                        <img src="{{ asset('uploads/' . $orderItem->product->image) }}" alt="{{ $orderItem->product->title }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" class="me-4">
                        <div>
                            <h5 class="fw-bold mb-2" style="color:var(--nykaa-dark);">{{ $orderItem->product->title }}</h5>
                            <div class="d-flex gap-4">
                                <span><span class="text-muted">Quantity:</span> <strong>{{ $orderItem->quantity }}</strong></span>
                                <span><span class="text-muted">Price (Each):</span> <strong>₹{{ number_format($orderItem->price, 2) }}</strong></span>
                            </div>
                            <h6 class="mt-2" style="color:var(--nykaa-pink);">
                                <strong>Total Earnings: ₹{{ number_format($orderItem->quantity * $orderItem->price, 2) }}</strong>
                            </h6>
                        </div>
                    @else
                        <p class="text-danger mb-0">This product has been deleted.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection