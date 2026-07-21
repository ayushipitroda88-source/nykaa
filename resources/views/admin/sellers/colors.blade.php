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
            <h3 class="mb-1">🎨 Seller Colors - {{ $seller->business_name }}</h3>
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
            <form method="GET" action="{{ route('admin.sellers.colors', $seller->id) }}" class="row g-2 align-items-center">
                <div class="col-md-6 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Search by color name or hex code..." value="{{ request('search') }}">
                        @if(request('search'))
                            <a href="{{ route('admin.sellers.colors', $seller->id) }}" class="btn btn-outline-secondary">
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

    {{-- Colors Table --}}
    <div class="card shadow">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-palette me-2"></i>Colors ({{ $colors->total() }})</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Color Preview</th>
                            <th>Color Name</th>
                            <th>Hex Code</th>
                            <th>Status</th>
                            <th>Created Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colors as $color)
                        <tr>
                            <td><strong>#{{ $color->id }}</strong></td>
                            <td>
                                <div style="width: 35px; height: 35px; border-radius: 50%; background-color: {{ $color->color_code }}; border: 2px solid #e0e0e0; box-shadow: 0 1px 3px rgba(0,0,0,0.1);"></div>
                            </td>
                            <td>{{ $color->name }}</td>
                            <td><code>{{ $color->color_code }}</code></td>
                            <td>
                                @if($color->status)
                                    <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Active</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $color->created_at->format('d M Y') }}</small>
                                <br>
                                <small class="text-muted">{{ $color->created_at->format('h:i A') }}</small>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.sellers.colors.destroy', [$seller->id, $color->id]) }}"
                                      method="POST"
                                      style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Delete this color? This action cannot be undone.')"
                                            title="Delete Color">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-palette fa-3x mb-3"></i>
                                    <h5>No Colors Found</h5>
                                    @if(request('search'))
                                        <p>No colors match your search criteria.</p>
                                    @else
                                        <p>This seller has not added any colors yet.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($colors->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3">
                {{ $colors->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection