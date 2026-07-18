@extends('layout.seller')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-primary text-white text-center">
                <h4>My Account</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Business Name</label>
                            <input type="text" name="business_name" class="form-control" required value="{{ old('business_name', $seller->business_name) }}">
                        </div>
                        <div class="col-md-6">
                            <label>Owner Name</label>
                            <input type="text" name="owner_name" class="form-control" required value="{{ old('owner_name', $seller->owner_name) }}">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email', $seller->email) }}">
                        </div>
                        <div class="col-md-6">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control" required value="{{ old('phone', $seller->phone) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Password <small class="text-muted">(Leave blank to keep current)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>GST Number (Optional)</label>
                            <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number', $seller->gst_number) }}">
                        </div>
                        <div class="col-md-6">
                            <label>PAN Number (Optional)</label>
                            <input type="text" name="pan_number" class="form-control" value="{{ old('pan_number', $seller->pan_number) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Business Logo</label>
                        @if($seller->business_logo)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $seller->business_logo) }}" alt="Logo" width="100" class="img-thumbnail">
                            </div>
                        @endif
                        <input type="file" name="business_logo" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label>Business Address</label>
                        <textarea name="business_address" class="form-control" rows="3" required>{{ old('business_address', $seller->business_address) }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
