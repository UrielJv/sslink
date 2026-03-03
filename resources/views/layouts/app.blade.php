<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'SSLink')</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo_sslink_blanco.png') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />

    <!-- Icons -->
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Argon CSS -->
    <link href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet">

    {{-- Toast --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    {{-- DataTable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <style>
        /* Oculta UI default de DataTables (usaremos la nuestra) */
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_length {
            display: none !important;
        }

        /* Que no meta margen raro */
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: .75rem 1rem;
        }

        table.dataTable {
            width: 100% !important;
        }

        .table td i {
            transition: 0.2s ease;
        }

        .table td a:hover i,
        .table td button:hover i {
            transform: scale(1.2);
        }

        .action-btn {
            background: transparent !important;
            border: none !important;
            padding: 0;
            margin: 0;
            box-shadow: none !important;
        }

        .action-btn:focus,
        .action-btn:active {
            background: transparent !important;
            box-shadow: none !important;
            outline: none !important;
        }
    </style>



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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            progressBar: true,
            positionClass: "toast-bottom-right",
            showDuration: 300,
            hideDuration: 1000,
            timeOut: 3000,
            closeButton: true
        };
    </script>

    {{-- Toastr messages --}}
    @if (session('success'))
        <script>
            toastr.success(@json(session('success')));
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error(@json(session('error')));
        </script>
    @endif

    @if (session('warning'))
        <script>
            toastr.warning(@json(session('warning')));
        </script>
    @endif

    @if (session('info'))
        <script>
            toastr.info(@json(session('info')));
        </script>
    @endif

    {{-- Validación (422) --}}
    @if ($errors->any())
        <script>
            toastr.error(`
            <ul style="margin:0; padding-left:18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        `);
        </script>
    @endif

    <script src="{{ asset('assets/js/core/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/argon-dashboard.min.js') }}"></script>

    @stack('javascript')
    @stack('scripts')

</body>

</html>
