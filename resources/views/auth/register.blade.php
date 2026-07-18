<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>


   

<div class="register-container">

    <div class="register-box">

        <h2>Create Account</h2>
        <p>Sign up to start shopping</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if ($errors->any())
                <div style="color: red; margin-bottom: 10px; font-size: 14px;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if(session('success'))
                <div style="color: green; margin-bottom: 10px; font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            <input type="text" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
            <input type="text" name="mobile" placeholder="Mobile Number" value="{{ old('mobile') }}" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

            <button type="submit">Register</button>
        </form>

        <div class="register-footer">
            Already have an account?
            <a href="{{ route('login') }}">Login</a>
        </div>

    </div>

</div>


</body>
</html>