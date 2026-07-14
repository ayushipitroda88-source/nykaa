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