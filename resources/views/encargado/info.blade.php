@extends('layouts.app')

@section('breadcrumb-parent', 'Inicio')
@section('breadcrumb-current', 'Mi información')
@section('page-title', 'Perfil del Encargado')

@section('content')
@php
    $user = auth()->user();
    $encargado = $user->encargado;
@endphp

@if(!$encargado)
    <div class="alert alert-warning">
        No hay información registrada.
    </div>
@else

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="card mb-4">
        <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">

            @php
                $iniciales = strtoupper(
                    mb_substr($user->nombre ?? 'E', 0, 1) .
                    mb_substr($user->apellido_paterno ?? '', 0, 1)
                );
            @endphp

            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-gradient-primary text-white d-flex align-items-center justify-content-center"
                     style="width:70px;height:70px;font-size:1.8rem;font-weight:700;">
                    {{ $iniciales }}
                </div>

                <div>
                    <h4 class="mb-0">
                        {{ $user->nombre }}
                        {{ $user->apellido_paterno }}
                        {{ $user->apellido_materno }}
                    </h4>
                    <div class="text-muted">
                        <span class="badge bg-info">{{ $encargado->cargo ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <span class="badge bg-primary">
                    Área: {{ $encargado->area ?? '—' }}
                </span>
            </div>

        </div>
    </div>

    {{-- KPIs específicos para encargado --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Estudiantes a cargo</div>
                    <h4>{{ $encargado->estudiantes()->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Estudiantes activos</div>
                    <h4>{{ $encargado->estudiantes()->where('estatus', 1)->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Estado</div>
                    @if($encargado->estatus)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-danger">Inactivo</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- INFORMACIÓN DETALLADA --}}
    <div class="row g-4 mb-4">

        {{-- INFORMACIÓN PERSONAL --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">Información personal</h6>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted">Correo electrónico</small>
                        <div class="fw-bold">{{ $user->email ?? '—' }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Teléfono</small>
                        <div class="fw-bold">{{ $user->telefono ?? '—' }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- INFORMACIÓN LABORAL --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">Información laboral</h6>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted">Área de trabajo</small>
                        <div class="fw-bold">{{ $encargado->area ?? '—' }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Cargo</small>
                        <div class="fw-bold">{{ $encargado->cargo ?? '—' }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Fecha de registro</small>
                        <div class="fw-bold">{{ $encargado->created_at ? $encargado->created_at->format('d/m/Y') : '—' }}</div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- LISTA DE ESTUDIANTES A CARGO --}}
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Estudiantes a cargo</h6>
        </div>
        <div class="card-body">
            @if($encargado->estudiantes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-flush">
                        <thead>
                            <tr>
                                <th>Matrícula</th>
                                <th>Nombre</th>
                                <th>Carrera</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($encargado->estudiantes as $estudiante)
                                <tr>
                                    <td>{{ $estudiante->matricula }}</td>
                                    <td>
                                        {{ $estudiante->user->nombre }}
                                        {{ $estudiante->user->apellido_paterno }}
                                    </td>
                                    <td>{{ $estudiante->carrera }}</td>
                                    <td>
                                        @if($estudiante->estatus)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">No tienes estudiantes asignados.</p>
            @endif
        </div>
    </div>

    {{-- BOTÓN DE CERRAR SESIÓN --}}
    <div class="row mt-4">
        <div class="col-12">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="fas fa-sign-out-alt me-2"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>

</div>
@endif
@endsection
