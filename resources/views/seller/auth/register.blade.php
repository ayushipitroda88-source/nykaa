@extends('layout.seller')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-success text-white text-center">
                <h4>Become a Nykaa Seller</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('seller.register.submit') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Business Name</label>
                            <input type="text" name="business_name" class="form-control" required value="{{ old('business_name') }}">
                        </div>
                        <div class="col-md-6">
                            <label>Owner Name</label>
                            <input type="text" name="owner_name" class="form-control" required value="{{ old('owner_name') }}">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Email Address</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>GST Number (Optional)</label>
                            <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}">
                        </div>
                        <div class="col-md-6">
                            <label>PAN Number (Optional)</label>
                            <input type="text" name="pan_number" class="form-control" value="{{ old('pan_number') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Business Logo</label>
                        <input type="file" name="business_logo" class="form-control" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label>Business Address</label>
                        <textarea name="business_address" class="form-control" rows="3" required>{{ old('business_address') }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Register as Seller</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
