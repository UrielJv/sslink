<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'SSLink')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- Argon CSS -->
    <link href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet">
</head>

<body class="g-sidenav-show bg-gray-100">

    <div class="min-height-300 bg-dark position-absolute w-100"></div>

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    <main class="main-content position-relative border-radius-lg">

        {{-- Navbar --}}
        @include('layouts.navbar')

        {{-- CONTENIDO --}}
        <div class="container-fluid py-4">
            @yield('content')

            {{-- Footer --}}
            {{-- @include('layouts.partials.footer') --}}
        </div>
    </main>

    <!-- Core JS -->
    <script src="{{ asset('assets/js/core/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/argon-dashboard.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
