@extends('layout.seller')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-10 col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0"><i class="fas fa-redo me-2"></i> Resubmit Your Application</h4>
            </div>
            <div class="card-body p-4">

                @if($seller->rejection_reason)
                    <div class="alert alert-danger" role="alert">
                        <h6 class="alert-heading fw-bold mb-2">
                            <i class="fas fa-exclamation-circle me-2"></i>Previous Rejection Reason:
                        </h6>
                        <p class="mb-0" style="white-space: pre-line;">{{ $seller->rejection_reason }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('seller.verification.resubmit.submit') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="business_name" class="form-label">Business Name <span class="text-danger">*</span></label>
                            <input type="text" name="business_name" id="business_name"
                                   class="form-control @error('business_name') is-invalid @enderror"
                                   value="{{ old('business_name', $seller->business_name) }}" required>
                            @error('business_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="owner_name" class="form-label">Owner Name <span class="text-danger">*</span></label>
                            <input type="text" name="owner_name" id="owner_name"
                                   class="form-control @error('owner_name') is-invalid @enderror"
                                   value="{{ old('owner_name', $seller->owner_name) }}" required>
                            @error('owner_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $seller->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" id="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $seller->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="gst_number" class="form-label">GST Number</label>
                            <input type="text" name="gst_number" id="gst_number"
                                   class="form-control @error('gst_number') is-invalid @enderror"
                                   value="{{ old('gst_number', $seller->gst_number) }}">
                            @error('gst_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="pan_number" class="form-label">PAN Number</label>
                            <input type="text" name="pan_number" id="pan_number"
                                   class="form-control @error('pan_number') is-invalid @enderror"
                                   value="{{ old('pan_number', $seller->pan_number) }}">
                            @error('pan_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="business_logo" class="form-label">Business Logo</label>
                        @if($seller->business_logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $seller->business_logo) }}"
                                     alt="Current Logo"
                                     class="img-thumbnail"
                                     style="max-height: 100px; max-width: 150px; object-fit: cover;">
                                <small class="d-block text-muted">Current logo. Upload a new one to replace it.</small>
                            </div>
                        @endif
                        <input type="file" name="business_logo" id="business_logo"
                               class="form-control @error('business_logo') is-invalid @enderror"
                               accept="image/*">
                        @error('business_logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="business_address" class="form-label">Business Address <span class="text-danger">*</span></label>
                        <textarea name="business_address" id="business_address"
                                  class="form-control @error('business_address') is-invalid @enderror"
                                  rows="3" required>{{ old('business_address', $seller->business_address) }}</textarea>
                        @error('business_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('seller.verification.status') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Back
                        </a>
                        <button type="submit" class="btn btn-primary px-5">
                            <i class="fas fa-paper-plane me-2"></i> Resubmit Application
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection