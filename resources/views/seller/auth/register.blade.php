@extends('layout.seller-auth')

@section('page-title', 'Seller Registration')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 680px;">
        <div class="auth-header">
            <div class="auth-brand">N</div>
            <h4>Become a Seller</h4>
            <p>Start selling your products on Nykaa</p>
        </div>
        <div class="auth-body">
            <form method="POST" action="{{ route('seller.register.submit') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Business Name</label>
                        <input type="text" name="business_name" class="form-control" required value="{{ old('business_name') }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Owner Name</label>
                        <input type="text" name="owner_name" class="form-control" required value="{{ old('owner_name') }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Email Address</label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Phone Number</label>
                        <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Password</label>
                        <input type="password" name="password" class="form-control" required style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">GST Number <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">PAN Number <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="pan_number" class="form-control" value="{{ old('pan_number') }}" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Business Logo</label>
                    <input type="file" name="business_logo" class="form-control" accept="image/*" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Business Address</label>
                    <textarea name="business_address" class="form-control" rows="3" required style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">{{ old('business_address') }}</textarea>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn-nykaa">Register as Seller</button>
                </div>
            </form>
            <div class="mt-4 text-center">
                <p class="mb-0" style="color:var(--nykaa-text-light);">
                    Already have an account?
                    <a href="{{ route('seller.login') }}" style="color:var(--nykaa-pink);font-weight:600;text-decoration:none;">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection