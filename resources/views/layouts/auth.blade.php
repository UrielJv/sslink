<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Iniciar sesión')</title>

    <link rel="icon" href="{{ secure_asset('auth-assets/images/logo-sm.png') }}" type="image/png">

    {{-- Librerías --}}
    <link rel="stylesheet" href="{{ secure_asset('auth-lib/bootstrap_5/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('auth-lib/fontawesome/css/all.min.css') }}">

    {{-- CSS del login --}}
    <link rel="stylesheet" href="{{ secure_asset('auth-assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('auth-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('auth-assets/css/responsive.css') }}">

    @stack('styles')
</head>

<body class="d2c_theme_light" style="background-color: #344767">

    @yield('content')

    {{-- JS (orden correcto) --}}
    <script src="{{ secure_asset('auth-lib/jQuery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ secure_asset('auth-lib/bootstrap_5/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ secure_asset('auth-assets/js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
