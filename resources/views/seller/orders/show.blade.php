@extends('layout.seller')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order Details #{{ $orderItem->order_id }}</h5>
                <a href="{{ route('seller.orders.index') }}" class="btn btn-sm btn-secondary">Back to Orders</a>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted border-bottom pb-2">Customer Information</h6>
                        <p class="mb-1"><strong>Name:</strong> {{ $orderItem->order->user->name ?? 'Unknown' }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $orderItem->order->user->email ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $orderItem->order->user->phone ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted border-bottom pb-2">Order Information</h6>
                        <p class="mb-1"><strong>Order Date:</strong> {{ $orderItem->created_at->format('d M Y, h:i A') }}</p>
                        <p class="mb-1">
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ optional($orderItem->order)->status == 'completed' ? 'success' : (optional($orderItem->order)->status == 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($orderItem->order->status ?? 'pending') }}
                            </span>
                        </p>
                        <p class="mb-1">
                            <strong>Payment Method:</strong> 
                            {{ strtoupper($orderItem->order->payment_method ?? 'N/A') }}
                            <span class="badge bg-{{ optional($orderItem->order)->payment_status == 'paid' ? 'success' : 'secondary' }} ms-1">
                                {{ ucfirst($orderItem->order->payment_status ?? 'pending') }}
                            </span>
                        </p>
                    </div>
                </div>

                <h6 class="text-muted border-bottom pb-2">Shipping Address</h6>
                <p class="mb-4">
                    {{ $orderItem->order->shipping_address ?? 'No shipping address provided.' }}
                </p>

                <h6 class="text-muted border-bottom pb-2">Product Details</h6>
                <div class="d-flex align-items-center mt-3 p-3 border rounded bg-light">
                    @if($orderItem->product)
                        <img src="{{ asset('uploads/' . $orderItem->product->image) }}" alt="{{ $orderItem->product->title }}" class="img-thumbnail me-4" style="width: 100px; height: 100px; object-fit: cover;">
                        <div>
                            <h5 class="mb-2">{{ $orderItem->product->title }}</h5>
                            <p class="mb-1"><strong>Quantity:</strong> {{ $orderItem->quantity }}</p>
                            <p class="mb-1"><strong>Price (Each):</strong> ₹{{ number_format($orderItem->price, 2) }}</p>
                            <h6 class="mt-2 text-primary"><strong>Total Earnings:</strong> ₹{{ number_format($orderItem->quantity * $orderItem->price, 2) }}</h6>
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
