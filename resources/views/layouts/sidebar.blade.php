<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="#" target="_blank">
            <img src="{{ asset('assets/img/logo_sslink.png') }}" alt="Logo">
            <span class="ms-1 font-weight-bold">Social Serve Link</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-scrollbar">
        <ul class="navbar-nav">
            @can('usuario.ver')
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
                            <i class="ni ni-hat-3 text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Estudiantes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('encargados.*') ? 'active' : '' }}"
                        href="{{ route('encargados.index') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-badge text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Encargados</span>
                    </a>
                </li>
            @endcan
            @role('encargado')
                @can('asistencia.ver')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('asistencias.*') ? 'active' : '' }}"
                            href="{{ route('asistencias.index') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-calendar-grid-58 text-dark text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Asistencias</span>
                        </a>
                    </li>
                @endcan
            @endrole

            {{-- MI INFORMACIÓN DINÁMICA SEGÚN EL ROL --}}
            @php
                $user = auth()->user();

                $infoRouteName = null;
                if ($user->hasRole('estudiante')) {
                    $infoRouteName = 'estudiante.info';
                } elseif ($user->hasRole('encargado')) {
                    $infoRouteName = 'encargado.info';
                } elseif ($user->hasRole('admin')) {
                    $infoRouteName = 'admin.info';
                }

                $infoRoute = $infoRouteName ? route($infoRouteName) : '#';
            @endphp

            @role('admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reportes.info') ? 'active' : '' }}"
                        href="{{ route('reportes.info') }}">

                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-flag text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">
                            Todos los Reportes
                        </span>
                    </a>
                </li>
            @endrole
            @role('estudiante|encargado')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('reportes.info') ? 'active' : '' }}"
                        href="{{ route('reportes.info') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-collection text-dark text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1"> Mis Reportes</span>
                    </a>
                </li>


                @role('estudiante')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('reportes.encargado.create') ? 'active' : '' }}"
                            href="{{ route('reportes.encargado.create') }}">
                            <div
                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="ni ni-send text-danger text-sm opacity-10"></i>
                            </div>
                            <span class="nav-link-text ms-1">Reportar</span>
                        </a>
                    </li>
                @endrole
            @endrole

            <li class="nav-item">
                <a class="nav-link {{ $infoRouteName && request()->routeIs($infoRouteName) ? 'active' : '' }}"
                    href="{{ $infoRoute }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Mi información</span>
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
