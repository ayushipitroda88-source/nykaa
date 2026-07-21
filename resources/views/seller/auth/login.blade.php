@extends('layout.seller')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-primary text-white text-center">
                <h4>Seller Login</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('seller.login.submit') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('seller.register') }}">Don't have an account? Register here</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
