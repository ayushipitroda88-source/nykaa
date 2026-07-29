@extends('layout.seller')

@section('page-title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1" style="color:var(--nykaa-dark);">My Orders</h4>
        <p class="text-muted mb-0">Track and manage customer orders</p>
    </div>
</div>

<div class="seller-card">
    <div class="card-body-custom p-0">
        <div class="table-responsive">
            <table class="seller-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orderItems as $item)
                        <tr>
                            <td><span class="fw-semibold">#{{ $item->order_id }}</span></td>
                            <td>
                                @if($item->product)
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('uploads/' . $item->product->image) }}" alt="{{ $item->product->title }}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;" class="me-2">
                                        <span>{{ Str::limit($item->product->title, 28) }}</span>
                                    </div>
                                @else
                                    <span style="color:var(--nykaa-danger);">Product Deleted</span>
                                @endif
                            </td>
                            <td>{{ $item->order->user->name ?? 'Unknown' }}</td>
                            <td class="fw-semibold">{{ $item->quantity }}</td>
                            <td class="fw-bold" style="color:var(--nykaa-dark);">₹{{ number_format($item->quantity * $item->price, 2) }}</td>
                            <td>
                                @php
                                    $status = $item->order->status ?? 'pending';
                                    $badgeClass = match($status) {
                                        'completed' => 'bg-approved',
                                        'cancelled' => 'bg-rejected',
                                        'pending' => 'bg-pending',
                                        default => 'bg-pending'
                                    };
                                @endphp
                                <span class="badge-nykaa {{ $badgeClass }}">{{ ucfirst($status) }}</span>
                            </td>
                            <td><small class="text-muted">{{ $item->created_at->format('d M Y, h:i A') }}</small></td>
                            <td>
                                <a href="{{ route('seller.orders.show', $item->id) }}" class="btn-action view">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5" style="color:var(--nykaa-text-light);">
                                <i class="fas fa-truck fa-2x mb-2 d-block"></i>
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection