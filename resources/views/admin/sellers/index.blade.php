@extends('layout.admin')

@section('content')
<div class="container-fluid mt-4">
    <h3 class="mb-4">👥 Seller Management</h3>

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

    {{-- Tab Navigation --}}
    <ul class="nav nav-tabs mb-3" id="approvalTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.sellers.index', ['tab' => 'all']) }}"
               class="nav-link {{ $tab == 'all' ? 'active' : '' }}">
                All <span class="badge bg-secondary ms-1">{{ $counts['all'] }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.sellers.index', ['tab' => 'pending']) }}"
               class="nav-link {{ $tab == 'pending' ? 'active' : '' }}">
                Pending <span class="badge bg-warning text-dark ms-1">{{ $counts['pending'] }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.sellers.index', ['tab' => 'approved']) }}"
               class="nav-link {{ $tab == 'approved' ? 'active' : '' }}">
                Approved <span class="badge bg-success ms-1">{{ $counts['approved'] }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.sellers.index', ['tab' => 'rejected']) }}"
               class="nav-link {{ $tab == 'rejected' ? 'active' : '' }}">
                Rejected <span class="badge bg-danger ms-1">{{ $counts['rejected'] }}</span>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{ route('admin.sellers.index', ['tab' => 'suspended']) }}"
               class="nav-link {{ $tab == 'suspended' ? 'active' : '' }}">
                Suspended <span class="badge bg-dark ms-1">{{ $counts['suspended'] }}</span>
            </a>
        </li>
    </ul>

    {{-- Sellers Table --}}
    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Logo</th>
                            <th>Business Name</th>
                            <th>Owner</th>
                            <th>Contact</th>
                            <th class="text-center">Colors</th>
                            <th class="text-center">Sizes</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sellers as $seller)
                        <tr>
                            {{-- Logo --}}
                            <td>
                                @if($seller->business_logo)
                                    <img src="{{ asset('storage/' . $seller->business_logo) }}"
                                         alt="{{ $seller->business_name }}"
                                         width="60" height="60"
                                         style="object-fit: cover; border-radius: 8px;">
                                @else
                                    <span class="text-muted"><i class="fas fa-store fa-2x"></i></span>
                                @endif
                            </td>

                            {{-- Business Name --}}
                            <td>
                                <strong>{{ $seller->business_name }}</strong>
                                <br>
                                <small class="text-muted">ID: #{{ $seller->id }}</small>
                            </td>

                            {{-- Owner --}}
                            <td>
                                <span class="fw-semibold">{{ $seller->owner_name }}</span>
                            </td>

                            {{-- Contact --}}
                            <td>
                                <span><i class="fas fa-envelope text-muted"></i> {{ $seller->email }}</span><br>
                                <span><i class="fas fa-phone text-muted"></i> {{ $seller->phone }}</span>
                            </td>

                            {{-- Colors Count --}}
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill fs-6">
                                    <i class="fas fa-palette me-1"></i> {{ $seller->colors_count ?? 0 }}
                                </span>
                            </td>

                            {{-- Sizes Count --}}
                            <td class="text-center">
                                <span class="badge bg-success rounded-pill fs-6">
                                    <i class="fas fa-ruler me-1"></i> {{ $seller->sizes_count ?? 0 }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($seller->status == 'pending')
                                    <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Pending</span>
                                @elseif($seller->status == 'approved')
                                    <span class="badge bg-success"><i class="fas fa-check"></i> Approved</span>
                                @elseif($seller->status == 'rejected')
                                    <span class="badge bg-danger"><i class="fas fa-times"></i> Rejected</span>
                                    @if($seller->rejection_reason)
                                        <br><small class="text-danger" title="{{ $seller->rejection_reason }}">{{ Str::limit($seller->rejection_reason, 20) }}</small>
                                    @endif
                                @elseif($seller->status == 'suspended')
                                    <span class="badge bg-dark"><i class="fas fa-ban"></i> Suspended</span>
                                @endif
                            </td>

                            {{-- Joined --}}
                            <td>
                                <small>{{ $seller->created_at->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ $seller->created_at->format('h:i A') }}</small>
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <a href="{{ route('admin.sellers.show', $seller->id) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.sellers.products', $seller->id) }}" class="btn btn-sm btn-outline-warning" title="View Products">
                                    <i class="fas fa-box"></i>
                                </a>

                                <a href="{{ route('admin.sellers.colors', $seller->id) }}" class="btn btn-sm btn-outline-primary" title="View Colors">
                                    <i class="fas fa-palette"></i>
                                </a>

                                <a href="{{ route('admin.sellers.sizes', $seller->id) }}" class="btn btn-sm btn-outline-success" title="View Sizes">
                                    <i class="fas fa-ruler"></i>
                                </a>

                                @if($seller->status == 'pending' || $seller->status == 'rejected' || $seller->status == 'suspended')
                                    <form action="{{ route('admin.sellers.status', $seller->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif

                                @if($seller->status == 'rejected' || $seller->status == 'suspended')
                                    <form action="{{ route('admin.sellers.status', $seller->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="pending">
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Set to Pending">
                                            <i class="fas fa-clock"></i>
                                        </button>
                                    </form>
                                @endif

                                @if($seller->status == 'pending' || $seller->status == 'approved')
                                    <button type="button" class="btn btn-sm btn-outline-danger" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $seller->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    
                                    {{-- Reject Modal --}}
                                    <div class="modal fade text-start" id="rejectModal{{ $seller->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $seller->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.sellers.status', $seller->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="rejectModalLabel{{ $seller->id }}">Reject Seller</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to reject the seller <strong>{{ $seller->business_name }}</strong>?</p>
                                                        <div class="mb-3">
                                                            <label for="rejection_reason_{{ $seller->id }}" class="form-label">Reason for Rejection <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="rejection_reason_{{ $seller->id }}" name="rejection_reason" rows="3" required placeholder="Please provide a reason for rejecting this seller..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Confirm Reject</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($seller->status == 'approved')
                                    <button type="button" class="btn btn-sm btn-outline-dark" title="Suspend" data-bs-toggle="modal" data-bs-target="#suspendModal{{ $seller->id }}">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                    
                                    {{-- Suspend Modal --}}
                                    <div class="modal fade text-start" id="suspendModal{{ $seller->id }}" tabindex="-1" aria-labelledby="suspendModalLabel{{ $seller->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.sellers.status', $seller->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="suspended">
                                                    <div class="modal-header bg-dark text-white">
                                                        <h5 class="modal-title" id="suspendModalLabel{{ $seller->id }}">Suspend Seller</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to suspend <strong>{{ $seller->business_name }}</strong>?</p>
                                                        <div class="mb-3">
                                                            <label for="suspension_reason_{{ $seller->id }}" class="form-label">Reason for Suspension <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="suspension_reason_{{ $seller->id }}" name="suspension_reason" rows="3" required placeholder="Please provide a reason for suspending this seller..."></textarea>
                                                            <div class="form-text">Examples: Fake products, Policy violation, Fraud, Too many complaints</div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-dark">Confirm Suspend</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Restore from Suspended --}}
                                @elseif($seller->status == 'suspended')
                                    <form action="{{ route('admin.sellers.status', $seller->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Restore to Approved">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-store-slash fa-3x mb-3"></i>
                                    <h5>No Sellers Found</h5>
                                    <p>There are no sellers matching the selected criteria.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($sellers->hasPages())
            <div class="card-footer bg-white border-top-0 pt-3">
                {{ $sellers->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
