@extends('layout.admin')

@section('title', 'Request Center')
@section('page-title', 'Request Center')

@section('content')
<div class="container-fluid px-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1">Request Center</h4>
                    <small class="text-muted">Review and manage seller change requests</small>
                </div>
                <div>
                    <span class="badge bg-warning text-dark p-2 me-1">Pending: {{ App\Models\RequestCenterRequest::where('status', 'pending')->count() }}</span>
                    <span class="badge bg-success p-2 me-1">Approved: {{ App\Models\RequestCenterRequest::where('status', 'approved')->count() }}</span>
                    <span class="badge bg-danger p-2">Rejected: {{ App\Models\RequestCenterRequest::where('status', 'rejected')->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Filter Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.request-center.index') ? 'active' : '' }}" 
               href="{{ route('admin.request-center.index') }}">
                All Requests
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.request-center.pending') ? 'active' : '' }}" 
               href="{{ route('admin.request-center.pending') }}">
                Pending <span class="badge bg-warning text-dark ms-1">{{ App\Models\RequestCenterRequest::where('status', 'pending')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.request-center.approved') ? 'active' : '' }}" 
               href="{{ route('admin.request-center.approved') }}">
                Approved <span class="badge bg-success ms-1">{{ App\Models\RequestCenterRequest::where('status', 'approved')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.request-center.rejected') ? 'active' : '' }}" 
               href="{{ route('admin.request-center.rejected') }}">
                Rejected <span class="badge bg-danger ms-1">{{ App\Models\RequestCenterRequest::where('status', 'rejected')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.request-center.need-more-info') ? 'active' : '' }}" 
               href="{{ route('admin.request-center.need-more-info') }}">
                Need Info <span class="badge bg-info ms-1">{{ App\Models\RequestCenterRequest::where('status', 'need_more_info')->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.request-center.history') ? 'active' : '' }}" 
               href="{{ route('admin.request-center.history') }}">
                History
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
                            <th>Seller</th>
                            <th>Type</th>
                            <th>Product</th>
                            <th>Variant</th>
                            <th>Status</th>
                            <th>Created</th>
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
                                <span class="small">{{ $req->seller ? $req->seller->business_name : 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark p-2 small">
                                    @if($req->request_type === 'product_edit')
                                        <i class="fas fa-edit text-primary"></i> Edit
                                    @elseif($req->request_type === 'product_delete')
                                        <i class="fas fa-trash text-danger"></i> Delete
                                    @elseif($req->request_type === 'variant_edit')
                                        <i class="fas fa-pen text-info"></i> Edit
                                    @elseif($req->request_type === 'variant_delete')
                                        <i class="fas fa-times text-warning"></i> Delete
                                    @endif
                                    {{ ucfirst(str_replace('_', ' ', $req->request_type)) }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $req->product ? $req->product->title : 'N/A' }}</small>
                            </td>
                            <td>
                                @if($req->variant)
                                    <small>{{ $req->variant->color ? $req->variant->color->name : 'N/A' }}</small>
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
                                <span class="small text-muted">{{ $req->created_at->format('d M Y') }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.request-center.show', $req->id) }}" 
                                   class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> Review
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    <h5>No requests found</h5>
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