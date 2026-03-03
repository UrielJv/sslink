@extends('layouts.app')

{{-- Nombre del tipo de usuario (Administracion, encargado, estudiante) --}}
@section('breadcrumb-parent', 'Administración')
{{-- Nombre de la accion en general (Reportes, tareas etc) --}}
@section('breadcrumb-current', 'Dashboard')
{{-- NNombre de accion en especifico (Registro, visualizacion etc) --}}
@section('page-title', 'Página de inicio')

@section('content')
    <div>
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">No. Usuarios</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $totalUsuarios }}
                                        </h5>
                                        {{-- <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+55%</span>
                                            since yesterday --}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="fa-solid fa-users text-2xl opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">No. Encargados</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $totalEncargados }}
                                        </h5>
                                        {{-- <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+3%</span>
                                            since last week --}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="fa-solid fa-user-tie text-2xl opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">No. Estudiantes</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $totalEstudiantes }}
                                        </h5>
                                        {{-- <p class="mb-0">
                                            <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                            since last quarter --}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="fa-solid fa-user-graduate text-2xl opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Estudiantes Activos</p>
                                        <h5 class="font-weight-bolder">
                                            {{ $estudiantesActivos }}
                                        </h5>
                                        {{-- <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                                        </p> --}}
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="fa-solid fa-user-check text-2xl opacity-10"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                {{-- Grafica principal --}}
                <div class="col-lg-8 mb-4">
                    <div class="card p-3">
                        <h6 class="mb-3">Estudiantes registrados (últimos 6 meses)</h6>
                        <div style="height: 300px;">
                            <canvas id="chartEstudiantesMes"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Grafica dona --}}
                <div class="col-lg-4 mb-4">
                    <div class="card p-3">
                        <h6 class="mb-3">Estado de estudiantes</h6>
                        <div style="height: 300px;">
                            <canvas id="chartEstadoEstudiantes"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">

                {{-- Gráfica --}}
                <div class="col-lg-8 mb-4">
                    <div class="card p-3">
                        <h6 class="mb-3">Asistencias por día (últimos 14 días)</h6>
                        <div style="height: 300px;">
                            <canvas id="chartAsistencias"></canvas>
                        </div>
                    </div>
                </div>

                {{-- Cards derecha --}}
                <div class="col-lg-4 mb-4">
                    <div class="row">

                        {{-- HOY --}}
                        <div class="col-12 mb-3">
                            <div class="card shadow-sm border-0 bg-gradient-primary text-white">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-xs text-uppercase mb-1 opacity-8">Asistencias hoy</p>
                                        <h3 class="mb-0 fw-bold text-white">{{ $asistHoy }}</h3>
                                    </div>
                                    <div class="icon icon-shape bg-white text-primary rounded-circle shadow text-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="fa-solid fa-calendar-day text-primary fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SEMANA --}}
                        <div class="col-12 mb-3">
                            <div class="card shadow-sm border-0 bg-gradient-success text-white">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-xs text-uppercase mb-1 opacity-8">Asistencias semana</p>
                                        <h3 class="mb-0 fw-bold text-white">{{ $asistSemana }}</h3>
                                    </div>
                                    <div class="icon icon-shape bg-white text-success rounded-circle shadow text-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="fa-solid fa-calendar-week text-success fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MES --}}
                        <div class="col-12">
                            <div class="card shadow-sm border-0 bg-gradient-warning text-white">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-xs text-uppercase mb-1 opacity-8">Asistencias mes</p>
                                        <h3 class="mb-0 fw-bold text-white">{{ $asistMes }}</h3>
                                    </div>
                                    <div class="icon icon-shape bg-white text-warning rounded-circle shadow text-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="fa-solid fa-calendar-days text-warning fa-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Ultimos 5 estudiantes registrados --}}
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card p-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Últimos 5 estudiantes registrados</h6>
                            <a href="{{ route('estudiantes.index') }}" class="btn btn-sm btn-outline-primary mb-0">
                                Ver todos
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Estudiante</th>
                                        <th>Correo</th>
                                        <th class="text-center">Estatus</th>
                                        <th class="text-end">Registrado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ultimosEstudiantes as $e)
                                        @php
                                            $u = $e->user;
                                            $inicial = $u ? strtoupper(mb_substr($u->nombre, 0, 1)) : 'E';
                                        @endphp

                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="avatar avatar-sm rounded-circle bg-gradient-secondary text-white d-flex align-items-center justify-content-center"
                                                        style="width:32px;height:32px;">
                                                        <span class="text-xs fw-bold">{{ $inicial }}</span>
                                                    </div>

                                                    <div class="d-flex flex-column">
                                                        <span class="fw-semibold">
                                                            {{ $u?->nombre }} {{ $u?->apellido_paterno }}
                                                            {{ $u?->apellido_materno }}
                                                        </span>
                                                        @if (!empty($u?->numero))
                                                            <small class="text-muted">Tel: {{ $u->numero }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-muted">
                                                {{ $u?->email ?? '-' }}
                                            </td>

                                            <td class="text-center">
                                                @if (($e->estatus ?? 0) == 1)
                                                    <span class="badge bg-success">Activo</span>
                                                @else
                                                    <span class="badge bg-secondary">Inactivo</span>
                                                @endif
                                            </td>

                                            <td class="text-end">
                                                <small class="text-muted">
                                                    {{ optional($e->created_at)->translatedFormat('d M Y, H:i') ?? '-' }}
                                                </small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                Aún no hay estudiantes registrados.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labelsMeses = @json($labelsMeses);
        const dataMeses = @json($dataMeses);

        const estudiantesActivos = @json($estudiantesActivos);
        const estudiantesInactivos = @json($estudiantesInactivos);

        // Grafica de barras
        new Chart(document.getElementById('chartEstudiantesMes'), {
            type: 'bar',
            data: {
                labels: labelsMeses,
                datasets: [{
                    label: 'Estudiantes',
                    data: dataMeses,
                    backgroundColor: '#5e72e4',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Grafica Dona
        new Chart(document.getElementById('chartEstadoEstudiantes'), {
            type: 'doughnut',
            data: {
                labels: ['Activos', 'Inactivos'],
                datasets: [{
                    data: [estudiantesActivos, estudiantesInactivos],
                    backgroundColor: ['#2dce89', '#f5365c'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

    <script>
        const labelsAsist = @json($labelsAsist);
        const dataAsist = @json($dataAsist);

        new Chart(document.getElementById('chartAsistencias'), {
            type: 'line',
            data: {
                labels: labelsAsist,
                datasets: [{
                    label: 'Asistencias',
                    data: dataAsist,
                    borderWidth: 2,
                    tension: 0.35,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
