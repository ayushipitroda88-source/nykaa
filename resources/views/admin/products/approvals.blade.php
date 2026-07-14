@extends('layout.admin')

@section('content')
<div class="container-fluid mt-4">
    <h3>Product Approvals</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="card shadow mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Seller</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->title }}</td>
                            <td>{{ $product->seller->business_name ?? 'N/A' }}</td>
                            <td>₹{{ $product->price }}</td>
                            <td>
                                <span class="badge 
                                    @if($product->status == 'pending') bg-warning 
                                    @elseif($product->status == 'approved') bg-success 
                                    @else bg-danger @endif">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.products.status', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                        <option value="pending" {{ $product->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $product->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                        <option value="rejected" {{ $product->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                    </select>
                                </form>
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
