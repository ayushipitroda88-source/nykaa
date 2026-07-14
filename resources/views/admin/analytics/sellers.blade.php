@extends('layout.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Seller Analytics</h3>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
               <thead class="table-dark">
                <tr>
                    <th>Seller Name</th>
                    <th class="text-center">Total Products</th>
                    <th class="text-center">Total Cart Users</th>
                    <th class="text-center">Total Wishlist Users</th>
                </tr>
                </thead>
                <tbody>
                    @forelse($sellers as $seller)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($seller->business_logo)
                                        <img src="{{ asset('uploads/'.$seller->business_logo) }}" alt="{{ $seller->business_name }}" style="width:40px; height:40px; object-fit:contain;" class="me-3">
                                    @endif
                                    <span>{{ $seller->business_name }}</span>
                                </div>
                            </td>
                            <td class="text-center">{{ $seller->products_count }}</td>
                            <td class="text-center"><span class="badge bg-primary fs-6">{{ $seller->cart_users_count ?? 0 }}</span></td>
                            <td class="text-center"><span class="badge bg-info text-dark fs-6">{{ $seller->wishlist_users_count ?? 0 }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No Seller Analytics Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            
            <div class="mt-3">
                {{ $sellers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
