@extends('layout.admin')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fas fa-store text-primary me-2"></i> Seller Details: {{ $seller->business_name }}</h3>
        <a href="{{ route('admin.sellers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Sellers
        </a>
    </div>

    <div class="row">
        {{-- Profile Card --}}
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-body text-center">
                    @if($seller->business_logo)
                        <img src="{{ asset('storage/' . $seller->business_logo) }}" 
                             alt="{{ $seller->business_name }}" 
                             class="img-fluid rounded-circle mb-3 border shadow-sm"
                             style="width: 150px; height: 150px; object-fit: cover;">
                    @else
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 border shadow-sm" style="width: 150px; height: 150px;">
                            <i class="fas fa-store fa-4x text-muted"></i>
                        </div>
                    @endif
                    <h4>{{ $seller->business_name }}</h4>
                    <p class="text-muted mb-2">{{ $seller->owner_name }}</p>
                    
                    <div class="mt-3">
                        @if($seller->status == 'pending')
                            <span class="badge bg-warning text-dark fs-6"><i class="fas fa-clock"></i> Pending Approval</span>
                        @elseif($seller->status == 'approved')
                            <span class="badge bg-success fs-6"><i class="fas fa-check"></i> Approved</span>
                        @elseif($seller->status == 'rejected')
                            <span class="badge bg-danger fs-6"><i class="fas fa-times"></i> Rejected</span>
                        @elseif($seller->status == 'suspended')
                            <span class="badge bg-dark fs-6"><i class="fas fa-ban"></i> Suspended</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Details Card --}}
        <div class="col-md-8 mb-4">
            <div class="card shadow h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Business Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Email:</div>
                        <div class="col-sm-8">{{ $seller->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Phone:</div>
                        <div class="col-sm-8">{{ $seller->phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Business Address:</div>
                        <div class="col-sm-8">{{ $seller->business_address }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">GST Number:</div>
                        <div class="col-sm-8">{{ $seller->gst_number ?? 'Not Provided' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">PAN Number:</div>
                        <div class="col-sm-8">{{ $seller->pan_number ?? 'Not Provided' }}</div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Bank Name:</div>
                        <div class="col-sm-8">{{ $seller->bank_name ?? 'Not Provided' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">Account Number:</div>
                        <div class="col-sm-8">{{ $seller->bank_account_number ?? 'Not Provided' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted fw-semibold">IFSC Code:</div>
                        <div class="col-sm-8">{{ $seller->ifsc_code ?? 'Not Provided' }}</div>
                    </div>
                    
                    @if($seller->status == 'rejected' && $seller->rejection_reason)
                        <hr>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-danger fw-semibold">Rejection Reason:</div>
                            <div class="col-sm-8 text-danger">{{ $seller->rejection_reason }}</div>
                        </div>
                        @if($seller->rejected_at)
                        <div class="row mb-3">
                            <div class="col-sm-4 text-danger fw-semibold">Rejected At:</div>
                            <div class="col-sm-8 text-danger">{{ $seller->rejected_at->format('d M Y h:i A') }}</div>
                        </div>
                        @endif
                    @endif

                    @if($seller->status == 'suspended' && $seller->suspension_reason)
                        <hr>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-dark fw-semibold">Suspension Reason:</div>
                            <div class="col-sm-8 text-dark">{{ $seller->suspension_reason }}</div>
                        </div>
                        @if($seller->suspended_at)
                        <div class="row mb-3">
                            <div class="col-sm-4 text-dark fw-semibold">Suspended At:</div>
                            <div class="col-sm-8 text-dark">{{ $seller->suspended_at->format('d M Y h:i A') }}</div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Navigation Cards --}}
    <div class="row mt-2 mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-compass me-2"></i> Quick Navigation</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        {{-- Products Card --}}
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.sellers.products', $seller->id) }}" class="text-decoration-none">
                                <div class="card border-0 bg-warning bg-opacity-10 h-100 hover-shadow">
                                    <div class="card-body text-center py-4">
                                        <div class="display-5 mb-2">
                                            <i class="fas fa-box text-warning"></i>
                                        </div>
                                        <h5 class="fw-bold mb-1">Products</h5>
                                        <span class="badge bg-warning text-dark fs-6 rounded-pill">{{ $seller->products_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Colors Card --}}
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.sellers.colors', $seller->id) }}" class="text-decoration-none">
                                <div class="card border-0 bg-primary bg-opacity-10 h-100 hover-shadow">
                                    <div class="card-body text-center py-4">
                                        <div class="display-5 mb-2">
                                            <i class="fas fa-palette text-primary"></i>
                                        </div>
                                        <h5 class="fw-bold mb-1">Colors</h5>
                                        <span class="badge bg-primary fs-6 rounded-pill">{{ $seller->colors_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Sizes Card --}}
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('admin.sellers.sizes', $seller->id) }}" class="text-decoration-none">
                                <div class="card border-0 bg-success bg-opacity-10 h-100 hover-shadow">
                                    <div class="card-body text-center py-4">
                                        <div class="display-5 mb-2">
                                            <i class="fas fa-ruler text-success"></i>
                                        </div>
                                        <h5 class="fw-bold mb-1">Sizes</h5>
                                        <span class="badge bg-success fs-6 rounded-pill">{{ $seller->sizes_count ?? 0 }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
