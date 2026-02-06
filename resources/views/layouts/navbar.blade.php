<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-white" href="{{ route('dashboard') }}">
                        @yield('breadcrumb-parent', 'Pages')
                    </a>
                </li>
                <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                    @yield('breadcrumb-current', 'Dashboard')
                </li>
            </ol>

            <h6 class="font-weight-bolder text-white mb-0">
                @yield('page-title', 'Dashboard')
            </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                </div>
            </div>
            <ul class="navbar-nav justify-content-end align-items-center gap-3">



                <li class="nav-item d-flex align-items-center">
                    <span class="nav-link text-white font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">
                            {{ auth()->user()->nombre }}
                        </span>
                    </span>
                </li>

                {{-- Notificaciones --}}
                <li class="nav-item dropdown d-flex align-items-center ms-2">
                    <a href="javascript:;" class="nav-link text-white p-0" id="notifMenu" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="notifMenu">
                        {{-- ...tu contenido... --}}
                    </ul>
                </li>

                {{-- Dropdown de configuración / logout --}}
                <li class="nav-item dropdown d-flex align-items-center ms-2">
                    <a href="javascript:;" class="nav-link text-white p-0" id="userMenu" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end px-2 py-2" aria-labelledby="userMenu"
                        style="min-width: 220px;">
                        <li class="px-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Cerrar sesión
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>



                {{-- Botón mostrar/ocultar sidebar (solo móvil) --}}
                <li class="nav-item d-xl-none d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>

            </ul>

        </div>
    </div>
</nav>
