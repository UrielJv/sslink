<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Iniciar sesión')</title>

    <link rel="icon" href="{{ asset('auth-assets/images/logo-sm.png') }}" type="image/png">

    {{-- Librerías --}}
    <link rel="stylesheet" href="{{ asset('auth-lib/bootstrap_5/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('auth-lib/fontawesome/css/all.min.css') }}">

    {{-- CSS del login --}}
    <link rel="stylesheet" href="{{ asset('auth-assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('auth-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('auth-assets/css/responsive.css') }}">

    @stack('styles')
</head>

<body class="d2c_theme_light" style="background-color: #344767">

    {{-- Preloader --}}
    {{-- <div class="preloader">
        <img src="{{ asset('auth-assets/images/logo.png') }}" alt="Logo">
    </div> --}}

    @yield('content')

    {{-- JS (orden correcto) --}}
    <script src="{{ asset('auth-lib/jQuery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('auth-lib/bootstrap_5/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('auth-assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
