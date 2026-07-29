@extends('layout.seller')

@section('page-title', 'Request Center')

@section('page-header')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Request Center</h4>
        <small class="text-muted">Manage your product and variant change requests</small>
    </div>
    <a href="{{ route('seller.request-center.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> New Request
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid px-0">

    <!-- Status Filter Tabs -->
    <ul class="nav nav-tabs mb-4 border-0">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.request-center.index') ? 'active' : '' }}" 
               href="{{ route('seller.request-center.index') }}">
                All Requests <span class="badge bg-secondary ms-1">{{ App\Models\RequestCenterRequest::where('seller_id', Auth::guard('seller')->id())->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.request-center.pending') ? 'active' : '' }}" 
               href="{{ route('seller.request-center.pending') }}">
                Pending <span class="badge bg-warning text-dark ms-1">{{ App\Models\RequestCenterRequest::where('seller_id', Auth::guard('seller')->id())->where('status', 'pending')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.request-center.approved') ? 'active' : '' }}" 
               href="{{ route('seller.request-center.approved') }}">
                Approved <span class="badge bg-success ms-1">{{ App\Models\RequestCenterRequest::where('seller_id', Auth::guard('seller')->id())->where('status', 'approved')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.request-center.rejected') ? 'active' : '' }}" 
               href="{{ route('seller.request-center.rejected') }}">
                Rejected <span class="badge bg-danger ms-1">{{ App\Models\RequestCenterRequest::where('seller_id', Auth::guard('seller')->id())->where('status', 'rejected')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('seller.request-center.need-more-info') ? 'active' : '' }}" 
               href="{{ route('seller.request-center.need-more-info') }}">
                Need Info <span class="badge bg-info ms-1">{{ App\Models\RequestCenterRequest::where('seller_id', Auth::guard('seller')->id())->where('status', 'need_more_info')->count() }}</span>
            </a>
        </li>
    </ul>

    <!-- Requests Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Request ID</th>
                            <th>Type</th>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Last Updated</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                        <tr>
                            <td>
                                <span class="fw-semibold">{{ $req->request_number }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark p-2">
                                    @if($req->request_type === 'product_edit')
                                        <i class="fas fa-edit text-primary me-1"></i> Edit Product
                                    @elseif($req->request_type === 'product_delete')
                                        <i class="fas fa-trash text-danger me-1"></i> Delete Product
                                    @elseif($req->request_type === 'variant_edit')
                                        <i class="fas fa-pen text-info me-1"></i> Edit Variant
                                    @elseif($req->request_type === 'variant_delete')
                                        <i class="fas fa-times text-warning me-1"></i> Delete Variant
                                    @endif
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('seller.variants.index', $req->product_id) }}" class="text-decoration-none">
                                    {{ $req->product ? $req->product->title : 'N/A' }}
                                </a>
                            </td>
                            <td>
                                @if($req->variant)
                                    <span class="small">
                                        {{ $req->variant->color ? $req->variant->color->name : 'N/A' }}
                                        @if($req->variant->sku) ({{ $req->variant->sku }}) @endif
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning text-dark',
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        'need_more_info' => 'bg-info text-dark',
                                    ];
                                    $class = $statusClasses[$req->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $class }} p-2">
                                    {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                </span>
                            </td>
                            <td>
                                <span class="small text-muted">{{ $req->created_at->format('d M Y, h:i A') }}</span>
                            </td>
                            <td>
                                <span class="small text-muted">{{ $req->updated_at->diffForHumans() }}</span>
                            </td>
                            <td>
                                <a href="{{ route('seller.request-center.show', $req->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    <h5>No requests found</h5>
                                    <p>Create your first request to get started.</p>
                                    <a href="{{ route('seller.request-center.create') }}" class="btn btn-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Create Request
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
@endsection
</write_to_file>