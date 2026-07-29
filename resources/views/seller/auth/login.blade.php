@extends('layout.seller-auth')

@section('page-title', 'Seller Login')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-brand">N</div>
            <h4>Welcome Back!</h4>
            <p>Sign in to your seller account</p>
        </div>
        <div class="auth-body">
            <form method="POST" action="{{ route('seller.login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Email Address</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="you@example.com" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                </div>
                <div class="mb-4">
                    <label class="form-label fw-semibold" style="color:var(--nykaa-dark);">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Enter your password" style="border:1.5px solid var(--nykaa-border);border-radius:8px;padding:10px 14px;">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn-nykaa">Sign In</button>
                </div>
            </form>
            <div class="mt-4 text-center">
                <p class="mb-0" style="color:var(--nykaa-text-light);">
                    Don't have an account?
                    <a href="{{ route('seller.register') }}" style="color:var(--nykaa-pink);font-weight:600;text-decoration:none;">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection