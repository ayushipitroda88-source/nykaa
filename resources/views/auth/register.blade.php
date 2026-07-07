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

            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="mobile" placeholder="Mobile Number" required>
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