@extends('layouts.app')

@section('breadcrumb-parent', 'Inicio')
@section('breadcrumb-current', 'Mi información')
@section('page-title', 'Perfil del Administrador')

@section('content')
@php
    $user = auth()->user();
@endphp

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="card mb-4">
        <div class="card-body d-flex flex-wrap align-items-center justify-content-between gap-3">

            @php
                $iniciales = strtoupper(
                    mb_substr($user->nombre ?? 'A', 0, 1) .
                    mb_substr($user->apellido_paterno ?? '', 0, 1)
                );
            @endphp

            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-gradient-dark text-white d-flex align-items-center justify-content-center"
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
                        <span class="badge bg-dark">Administrador del sistema</span>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <span class="badge bg-primary">
                    <i class="fas fa-shield-alt me-1"></i> Acceso total
                </span>
            </div>

        </div>
    </div>

    {{-- KPIs del sistema (consultas directas a las tablas) --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Total Estudiantes</div>
                    <h4>{{ \App\Models\Estudiante::count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Total Encargados</div>
                    <h4>{{ \App\Models\Encargado::count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Estado</div>
                    <span class="badge bg-success">Activo</span>
                </div>
            </div>
        </div>
    </div>

    {{-- INFORMACIÓN PERSONAL (desde tabla users) --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Información personal</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Correo electrónico</small>
                                <div class="fw-bold">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Teléfono</small>
                                <div class="fw-bold">{{ $user->telefono ?? 'No registrado' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Fecha de registro</small>
                                <div class="fw-bold">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '—' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Última actualización</small>
                                <div class="fw-bold">{{ $user->updated_at ? $user->updated_at->format('d/m/Y') : '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
@endsection
