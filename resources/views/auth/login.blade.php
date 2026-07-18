<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nykaa</title>

    <!-- Font Awesome (for icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT: Branding / Visual 
    <div class="login-branding">
        <div class="branding-content">
            <div class="brand-logo">
                <span class="brand-dot"></span>
                <span class="brand-text">NYKAA</span>
            </div>
            <h2 class="brand-tagline">Beauty that<br>speaks for itself</h2>
            <p class="brand-desc">
                Discover thousands of beauty, skincare & makeup products curated just for you.
            </p>
            <div class="brand-features">
                <div class="brand-feature">
                    <i class="fas fa-truck"></i>
                    <span>Free shipping on orders ₹499+</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Easy 15-day returns</span>
                </div>
                <div class="brand-feature">
                    <i class="fas fa-shield-alt"></i>
                    <span>100% authentic products</span>
                </div>
            </div>
        </div>
    </div>
-->
    <!-- RIGHT: Login Form -->
    <div class="login-form-section">

        <div class="login-card">

            <!-- Mobile Logo -->
            <div class="mobile-logo">
                <span class="brand-text">NYKAA</span>
            </div>

            <div class="login-header">
                <h2>Welcome Back</h2>
                <p>Sign in to your account to continue</p>
            </div>

            <form method="POST" action="{{ route('login.submit') }}" class="login-form">
                @csrf

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="form-alert form-alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Success Messages -->
                @if(session('success'))
                    <div class="form-alert form-alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Email -->
                <div class="input-group">
                    <label for="email">Email Address</label>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="Enter your email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password -->
                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="Enter your password"
                            required
                            autocomplete="current-password"
                        >
                        
                    </div>
                </div>

               

                <!-- Submit -->
                <button type="submit" class="btn-login">
                    <span>Sign In</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Register Link -->
            <div class="login-footer">
                <p>Don't have an account?</p>
                <a href="{{ route('register.page') }}" class="register-link">
                    Create Account <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </div>

        </div>

    </div>

</div>

<script>
function togglePassword() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('toggleIcon');
    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        pwd.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

</body>
</html>