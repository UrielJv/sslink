<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#" target="_blank">
            <img src="../assets/img/sslink_logo.png" class="navbar-brand-img" style="height:100px; width:auto; object-fit:contain;" alt="main_logo">
            <span class="ms-1 font-weight-bold">Social Serve Link</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-scrollbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('estudiantes.*') ? 'active' : '' }}"
                    href="{{ route('estudiantes.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Estudiantes</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('encargados.*') ? 'active' : '' }}"
                    href="{{ route('encargados.index') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Encargados</span>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a class="nav-link " href="../pages/tables.html">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Tables</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="mt-auto px-3 pb-3">
                        @csrf
                        <button type="submit"
                            class="btn btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Cerrar sesión
                        </button>
                    </form>
                @endauth
            </li> --}}



        </ul>
    </div>

</aside>
