@extends('layouts.app')

@section('breadcrumb-parent', 'Asistencias')
@section('breadcrumb-current', 'Historial')
@section('page-title', 'Historial de asistencias')

@section('content')

    @php
        $nombreCompleto = trim(
            ($estudiante->user->nombre ?? '') .
                ' ' .
                ($estudiante->user->apellido_paterno ?? '') .
                ' ' .
                ($estudiante->user->apellido_materno ?? ''),
        );

        $totalAsistencias = $asistencias->count();
        $totalHorasHistorial = $asistencias->sum('horas_cumplidas');
        $horasActuales = $estudiante->horas_actuales ?? 0;
        $horasRequeridas = $estudiante->horas_requeridas ?? null;

        $porcentaje = null;
        if ($horasRequeridas && $horasRequeridas > 0) {
            $porcentaje = min(100, round(($horasActuales / $horasRequeridas) * 100));
        }
    @endphp

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Historial de asistencias</h4>

            <div class="d-flex flex-wrap gap-2 mt-2">
                <span class="badge bg-light text-dark">
                    <i class="ni ni-single-02 me-1"></i> {{ $nombreCompleto ?: 'Alumno' }}
                </span>

                @if (!empty($estudiante->matricula))
                    <span class="badge bg-light text-dark">
                        <i class="ni ni-credit-card me-1"></i> Matrícula: {{ $estudiante->matricula }}
                    </span>
                @endif

                @if (!empty($estudiante->carrera))
                    <span class="badge bg-light text-dark">
                        <i class="ni ni-books me-1"></i> {{ $estudiante->carrera }}
                    </span>
                @endif

                @if (!empty($estudiante->area))
                    <span class="badge bg-light text-dark">
                        <i class="ni ni-building me-1"></i> {{ $estudiante->area }}
                    </span>
                @endif
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('asistencias.index') }}" class="btn btn-outline-secondary">
                <i class="ni ni-bold-left me-1"></i> Volver
            </a>
             {{-- Reporte --}}
                                        <td class="align-middle text-center">
                                            <a href="{{ route('reportes.create', $estudiante->id) }}"
                                                class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-flag me-1"></i> Subir reporte
                                            </a>
                                        

            <a href="{{ route('asistencias.create', ['estudiante_id' => $estudiante->id]) }}" class="btn btn-primary">
                <i class="ni ni-fat-add me-1"></i> Nueva asistencia
            </a>
        </div>
    </div>

    {{-- Cards resumen --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div
                            class="icon icon-shape icon-sm bg-primary text-white border-radius-md d-flex align-items-center justify-content-center">
                            <i class="ni ni-bullet-list-67"></i>
                        </div>
                        <div class="text-muted small">Asistencias registradas</div>
                    </div>
                    <div class="h4 mb-0 fw-bold">{{ $totalAsistencias }}</div>
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
                        <div class="text-muted small">Horas acumuladas (historial)</div>
                    </div>
                    <div class="h4 mb-0 fw-bold">{{ number_format($totalHorasHistorial, 0) }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div
                            class="icon icon-shape icon-sm bg-success text-white border-radius-md d-flex align-items-center justify-content-center">
                            <i class="ni ni-chart-bar-32"></i>
                        </div>
                        <div class="text-muted small">Horas actuales (estudiante)</div>
                    </div>
                    <div class="h4 mb-0 fw-bold">{{ number_format($horasActuales, 0) }}</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div
                            class="icon icon-shape icon-sm bg-secondary text-white border-radius-md d-flex align-items-center justify-content-center">
                            <i class="ni ni-trophy"></i>
                        </div>
                        <div class="text-muted small">Progreso</div>
                    </div>

                    @if ($porcentaje !== null)
                        <div class="d-flex justify-content-between small text-muted mb-1">
                            <span>{{ number_format($horasActuales, 0) }} / {{ number_format($horasRequeridas, 0) }}</span>
                            <span class="fw-semibold">{{ $porcentaje }}%</span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ $porcentaje }}%;"
                                aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    @else
                        <div class="text-muted">Sin horas requeridas configuradas</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla registros --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Registros</h6>
            <div class="text-muted small">Ordenado por fecha (desc)</div>
        </div>

        <div class="card-body">
            @if ($asistencias->isEmpty())
                <div class="text-center text-muted py-5">
                    <div class="mb-2">
                        <i class="ni ni-calendar-grid-58" style="font-size: 40px;"></i>
                    </div>
                    <div class="fw-semibold">Aún no hay asistencias registradas</div>
                    <div class="small">Cuando registres una asistencia, aparecerá aquí.</div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th style="width: 140px;">Fecha</th>
                                <th style="width: 140px;">Estado</th>
                                <th style="width: 120px;">Horas</th>
                                <th>Observaciones</th>
                                <th style="width: 160px;" class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asistencias as $a)
                                @php
                                    $estado = strtolower($a->estado);
                                    $badge = match ($estado) {
                                        'presente' => 'bg-success',
                                        'ausente' => 'bg-danger',
                                        'justificado' => 'bg-warning text-dark',
                                        default => 'bg-secondary',
                                    };
                                @endphp

                                <tr>
                                    <td class="fw-semibold">
                                        <i class="ni ni-calendar-grid-58 text-primary me-1"></i>
                                        {{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y') }}
                                    </td>

                                    <td>
                                        <span class="badge {{ $badge }} px-3 py-2">
                                            {{ strtoupper($estado) }}
                                        </span>
                                    </td>

                                    <td class="fw-semibold">
                                        {{ number_format($a->horas_cumplidas ?? 0, 0) }}
                                    </td>

                                    <td class="text-muted">
                                        {{ $a->observaciones ?: 'Sin observaciones' }}
                                    </td>

                                    <td class="text-end">
                                        <a href="{{ route('asistencias.show', $a->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye me-1"></i> Ver detalle
                                        </a>
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
