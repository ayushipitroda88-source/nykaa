<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nykaa Seller Center - @yield('page-title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Seller Custom CSS -->
    <link href="{{ asset('css/seller.css') }}" rel="stylesheet">
</head>
<body>
    @yield('content')

    {{-- Alerts --}}
    @if(session('success'))
        <div style="position:fixed;top:20px;right:20px;z-index:9999;max-width:400px;" class="seller-alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="position:fixed;top:20px;right:20px;z-index:9999;max-width:400px;" class="seller-alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0 mt-1 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>