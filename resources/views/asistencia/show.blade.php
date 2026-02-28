@extends('layouts.app')

@section('breadcrumb-parent', 'Asistencias')
@section('breadcrumb-current', 'Detalle')
@section('page-title', 'Detalle de asistencia')

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Detalle de asistencia</h4>

            <div class="d-flex flex-wrap gap-2 mt-2">
                <span class="badge bg-light text-dark">
                    <i class="ni ni-single-02 me-1"></i>
                    {{ $asistencia->estudiante->user->nombre ?? '' }}
                    {{ $asistencia->estudiante->user->apellido_paterno ?? '' }}
                    {{ $asistencia->estudiante->user->apellido_materno ?? '' }}
                </span>

                @if (!empty($asistencia->estudiante->matricula))
                    <span class="badge bg-light text-dark">
                        <i class="ni ni-credit-card me-1"></i>
                        Matrícula: {{ $asistencia->estudiante->matricula }}
                    </span>
                @endif

                <span class="badge bg-light text-dark">
                    <i class="ni ni-calendar-grid-58 me-1"></i>
                    {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                </span>
            </div>
        </div>

        <a href="{{ route('asistencias.historial', $asistencia->estudiante_id) }}" class="btn btn-outline-secondary">
            <i class="ni ni-bold-left me-1"></i> Volver
        </a>
    </div>

    @php
        $estado = strtolower($asistencia->estado);
        $badge = match ($estado) {
            'presente' => 'bg-success',
            'ausente' => 'bg-danger',
            'justificado' => 'bg-warning text-dark',
            default => 'bg-secondary',
        };
    @endphp

    {{-- Resumen en cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div
                            class="icon icon-shape icon-sm bg-primary text-white border-radius-md d-flex align-items-center justify-content-center">
                            <i class="ni ni-calendar-grid-58"></i>
                        </div>
                        <div class="text-muted small">Fecha</div>
                    </div>
                    <div class="h6 mb-0 fw-bold">
                        {{ \Carbon\Carbon::parse($asistencia->fecha)->format('d/m/Y') }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div
                            class="icon icon-shape icon-sm bg-success text-white border-radius-md d-flex align-items-center justify-content-center">
                            <i class="ni ni-check-bold"></i>
                        </div>
                        <div class="text-muted small">Estado</div>
                    </div>

                    <span class="badge {{ $badge }} px-3 py-2">
                        {{ ucfirst($estado) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div
                            class="icon icon-shape icon-sm bg-info text-white border-radius-md d-flex align-items-center justify-content-center">
                            <i class="ni ni-time-alarm"></i>
                        </div>
                        <div class="text-muted small">Horas registradas</div>
                    </div>
                    <div class="h5 mb-0 fw-bold">
                        {{ number_format($asistencia->horas_cumplidas ?? 0, 0) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div
                            class="icon icon-shape icon-sm bg-secondary text-white border-radius-md d-flex align-items-center justify-content-center">
                            <i class="ni ni-single-copy-04"></i>
                        </div>
                        <div class="text-muted small">Observaciones</div>
                    </div>
                    <div class="mb-0">
                        {{ $asistencia->observaciones ?: 'Sin observaciones' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Actividades --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Actividades registradas</h6>

            @php
                $totalActividades = $asistencia->actividades->count();
                $totalHorasAct = $asistencia->actividades->sum('horas');
            @endphp

            <div class="text-muted small">
                <span class="me-2">Actividades: <strong>{{ $totalActividades }}</strong></span>
                <span>Horas: <strong>{{ number_format($totalHorasAct, 0) }}</strong></span>
            </div>
        </div>

        <div class="card-body">
            @if ($asistencia->actividades->isEmpty())
                <div class="text-center text-muted py-5">
                    <div class="mb-2">
                        <i class="ni ni-bullet-list-67" style="font-size: 40px;"></i>
                    </div>
                    <div class="fw-semibold">No hay actividades registradas</div>
                    <div class="small">Agrega actividades al registrar la asistencia.</div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Actividad</th>
                                <th>Descripción</th>
                                <th style="width: 120px;">Horas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asistencia->actividades as $actividad)
                                <tr>
                                    <td class="fw-semibold">
                                        <i class="ni ni-tag text-primary me-1"></i>
                                        {{ $actividad->nombre }}
                                    </td>
                                    <td class="text-muted">
                                        {{ $actividad->descripcion }}
                                    </td>
                                    <td class="fw-semibold">
                                        {{ number_format($actividad->horas ?? 0, 0) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection
