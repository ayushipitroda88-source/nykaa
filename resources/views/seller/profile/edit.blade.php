@extends('layout.seller')

@section('page-title', 'My Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="seller-card p-4">
            <div class="text-center mb-4">
                @php
                    $seller = Auth::guard('seller')->user();
                    $initial = strtoupper(substr($seller->business_name, 0, 1));
                @endphp
                <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,var(--nykaa-pink),var(--nykaa-purple));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:32px;margin:0 auto 12px;">
                    {{ $initial }}
                </div>
                <h4 class="fw-bold mb-1" style="color:var(--nykaa-dark);">My Account</h4>
                <p class="text-muted mb-0">Manage your seller profile information</p>
            </div>

            <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Business Name</label>
                        <input type="text" name="business_name" class="form-control" required value="{{ old('business_name', $seller->business_name) }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Owner Name</label>
                        <input type="text" name="owner_name" class="form-control" required value="{{ old('owner_name', $seller->owner_name) }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Email Address</label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email', $seller->email) }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required value="{{ old('phone', $seller->phone) }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Password <small class="text-muted">(Leave blank to keep current)</small></label>
                        <input type="password" name="password" class="form-control" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">GST Number <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number', $seller->gst_number) }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">PAN Number <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="pan_number" class="form-control" value="{{ old('pan_number', $seller->pan_number) }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Business Logo</label>
                    @if($seller->business_logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $seller->business_logo) }}" alt="Logo" width="80" style="border-radius:8px;border:1px solid var(--nykaa-border);">
                        </div>
                    @endif
                    <input type="file" name="business_logo" class="form-control" accept="image/*" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Business Address</label>
                    <textarea name="business_address" class="form-control" rows="3" required style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">{{ old('business_address', $seller->business_address) }}</textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn-nykaa">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection