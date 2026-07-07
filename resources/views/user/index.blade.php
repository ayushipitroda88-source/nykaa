<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium e-commerce platform inspired by Nykaa">
    <title>@yield('title', 'Nykaa - Premium Beauty & Fashion')</title>

    <!-- Fonts -->
    @fonts

    <!-- Vite Styles & Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Page-specific styles -->
    @stack('page-styles')
</head>
<body class="bg-brand-light text-brand-dark">

    <!-- Header -->
    @include('user.header')

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('user.footer')

    <!-- Page-specific scripts -->
    @stack('page-scripts')

</body>
</html>