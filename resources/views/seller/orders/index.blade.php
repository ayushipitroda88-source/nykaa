@extends('layout.seller')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">My Orders</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Price (Each)</th>
                        <th>Total</th>
                        <th>Order Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orderItems as $item)
                        <tr>
                            <td class="align-middle">#{{ $item->order_id }}</td>
                            <td class="align-middle">
                                @if($item->product)
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('uploads/' . $item->product->image) }}" alt="{{ $item->product->title }}" class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                        <span>{{ Str::limit($item->product->title, 30) }}</span>
                                    </div>
                                @else
                                    <span class="text-danger">Product Deleted</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $item->order->user->name ?? 'Unknown' }}</td>
                            <td class="align-middle">{{ $item->quantity }}</td>
                            <td class="align-middle">₹{{ number_format($item->price, 2) }}</td>
                            <td class="align-middle">₹{{ number_format($item->quantity * $item->price, 2) }}</td>
                            <td class="align-middle">
                                <span class="badge bg-{{ optional($item->order)->status == 'completed' ? 'success' : (optional($item->order)->status == 'cancelled' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($item->order->status ?? 'pending') }}
                                </span>
                            </td>
                            <td class="align-middle">{{ $item->created_at->format('d M Y, h:i A') }}</td>
                            <td class="align-middle">
                                <a href="{{ route('seller.orders.show', $item->id) }}" class="btn btn-sm btn-info text-white">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
