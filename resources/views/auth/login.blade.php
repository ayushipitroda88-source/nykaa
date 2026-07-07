<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <!-- CSS ADD HERE -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

<!-- LOGIN MODAL -->
<div class="login-modal" style="display:block;">  <!-- abhi test ke liye block -->
    
    <div class="login-content">

        <span class="close-login">&times;</span>

        <h2>Welcome Back</h2>
        <p>Login to continue</p>

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>
        </form>

        <div class="modal-footer-text">
            Don’t have an account?
           <a href="{{ route('register.page') }}" class="text-link">Register</a>
        </div>

    </div>

</div>
<script>
document.querySelector(".close-login").addEventListener("click", function () {
    document.querySelector(".login-modal").style.display = "none";
});
</script>
</body>
</html>