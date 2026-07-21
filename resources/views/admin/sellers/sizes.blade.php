@extends('layout.admin')

@section('content')
<div class="container-fluid mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">📏 Seller Sizes - {{ $seller->business_name }}</h3>
            <p class="text-muted mb-0">
                <i class="fas fa-store me-1"></i> {{ $seller->owner_name }} 
                <span class="mx-2">|</span>
                <i class="fas fa-envelope me-1"></i> {{ $seller->email }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Sellers
            </a>
        </div>
    </div>

    {{-- Search --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('admin.sellers.sizes', $seller->id) }}" class="row g-2 align-items-center">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search by size name..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('admin.sellers.sizes', $seller->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Sizes Table --}}
    <div class="card shadow">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-ruler me-2"></i>Sizes ({{ $sizes->total() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Size Name</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sizes as $size)
                        <tr>
                            <td><strong>#{{ $size->id }}</strong></td>
                            <td>
                                <span class="fw-semibold">{{ $size->name }}</span>
                            </td>
                            <td>
                                @if($size->status)
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $size->created_at->format('d M Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $size->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.sellers.sizes.destroy', [$seller->id, $size->id]) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this size? This action cannot be undone.')"
                                            title="Delete Size">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-ruler fa-3x mb-3"></i>
                                    <h5>No Sizes Found</h5>
                                    @if(request('search'))
                                        <p>No sizes match your search criteria.</p>
                                    @else
                                        <p>This seller has not added any sizes yet.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($sizes->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3">
                {{ $sizes->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection