@extends('layouts.app')

@section('breadcrumb-parent', 'Inicio')
@section('breadcrumb-current', 'Mi información')
@section('page-title', 'Perfil del estudiante')

@section('content')
@php
    $user = auth()->user();
    $estudiante = $user->estudiante;
@endphp

@if(!$estudiante)
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
                        {{ $estudiante->carrera ?? '—' }} · {{ $estudiante->escuela ?? '—' }}
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('bitacora.descargar', $estudiante->id) }}" class="btn btn-success mb-2">
                    <i class="fas fa-file-excel me-1"></i> Bitácora
                </a>
                <div>
                    <span class="badge bg-info">
                        Matrícula: {{ $estudiante->matricula ?? '—' }}
                    </span>
                </div>
            </div>

        </div>
    </div>

    {{-- KPIs (SIN CAMBIOS) --}}
    @php
        $req = (int) ($estudiante->horas_requeridas ?? 0);
        $act = (int) ($estudiante->horas_actuales ?? 0);
        $pct = $req > 0 ? min(100, round(($act / $req) * 100)) : 0;
    @endphp

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Horas requeridas</div>
                    <h4>{{ $req }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Horas acumuladas</div>
                    <h4>{{ $act }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Progreso</div>
                    <h4>{{ $pct }}%</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="text-xs text-muted">Estado</div>
                    @if($act >= $req && $req > 0)
                        <span class="badge bg-success">Completado</span>
                    @else
                        <span class="badge bg-warning">En proceso</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- INFO --}}
    <div class="row g-4 mb-4">

        {{-- PERSONAL --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">Información personal</h6>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted">Sexo</small>
                        <div class="fw-bold">{{ $estudiante->sexo ?? '—' }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Teléfono</small>
                        <div class="fw-bold">{{ $user->telefono ?? '—' }}</div>
                    </div>

                    <div>
                        <small class="text-muted">Teléfono del tutor</small>
                        <div class="fw-bold">{{ $estudiante->telefono_tutor ?? '—' }}</div>
                    </div>

                </div>
            </div>
        </div>

        {{-- SERVICIO --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">Servicio social</h6>
                </div>
                <div class="card-body">

                    <div class="mb-3">
                        <small class="text-muted">Área asignada</small>
                        <div class="fw-bold">{{ $estudiante->area ?? '—' }}</div>
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Encargado</small>
                        <div class="fw-bold">
                            {{ $estudiante->encargado?->user?->nombre ?? '—' }}
                            {{ $estudiante->encargado?->user?->apellido_paterno ?? '' }}
                        </div>
                    </div>

                    <div>
                        <small class="text-muted">Escuela</small>
                        <div class="fw-bold">{{ $estudiante->escuela ?? '—' }}</div>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {{-- DIRECCIÓN (VERSIÓN LIMPIA Y PRO) --}}
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Dirección</h6>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <small class="text-muted">Dirección completa</small>
                <div class="fw-bold fs-6">
                    {{ $estudiante->calle ?? '—' }}
                    #{{ $estudiante->numero_exterior ?? '—' }}
                    @if($estudiante->numero_interior)
                        Int. {{ $estudiante->numero_interior }},
                    @endif
                    {{ $estudiante->colonia ?? '—' }},
                    {{ $estudiante->municipio ?? '—' }},
                    C.P. {{ $estudiante->codigo_postal ?? '—' }}
                </div>
            </div>

            <div class="d-flex gap-4 text-muted small">
                <span><strong>Municipio:</strong> {{ $estudiante->municipio ?? '—' }}</span>
                <span><strong>Colonia:</strong> {{ $estudiante->colonia ?? '—' }}</span>
                <span><strong>C.P.:</strong> {{ $estudiante->codigo_postal ?? '—' }}</span>
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
@endif
@endsection
