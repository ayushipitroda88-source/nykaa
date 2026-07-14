@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Brand Analytics</h3>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
               <thead class="table-dark">
                <tr>
                    <th>Brand Name</th>
                    <th class="text-center">Total Products</th>
                    <th class="text-center">Total Cart Users</th>
                    <th class="text-center">Total Wishlist Users</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($brand->logo)
                                        <img src="{{ asset('uploads/'.$brand->logo) }}" alt="{{ $brand->name }}" style="width:40px; height:40px; object-fit:contain;" class="me-3">
                                    @endif
                                    <span>{{ $brand->name }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $brand->products_count }}</td>
                            <td class="text-center"><span class="badge bg-primary fs-6">{{ $brand->cart_users_count ?? 0 }}</span></td>
                            <td class="text-center"><span class="badge bg-info text-dark fs-6">{{ $brand->wishlist_users_count ?? 0 }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No Brand Analytics Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-3">
                {{ $brands->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
