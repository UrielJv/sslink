@extends('layouts.app')

@section('breadcrumb-parent', 'Administración')
@section('breadcrumb-current', 'Estudiantes')
@section('page-title', 'Detalle de estudiante')

@section('content')
    <div class="container-fluid py-4">

        {{-- Acciones --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('estudiantes.index') }}" class="btn btn-secondary">
                ← Volver
            </a>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('estudiantes.edit', $estudiante->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Editar
                </a>

                <form class="m-0" action="{{ route('estudiantes.destroy', $estudiante->id) }}" method="POST"
                    onsubmit="return confirm('¿Seguro que deseas eliminar este estudiante?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>

        {{-- Card principal --}}
        <div class="card">

            {{-- Header visual tipo perfil --}}
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                    <div class="d-flex align-items-center gap-3">
                        {{-- Avatar (iniciales) --}}
                        @php
                            $nombre = $estudiante->user->nombre ?? '';
                            $ap = $estudiante->user->apellido_paterno ?? '';
                            $iniciales = strtoupper(mb_substr($nombre, 0, 1) . mb_substr($ap, 0, 1));
                        @endphp

                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;font-weight:700;">
                            {{ $iniciales ?: 'E' }}
                        </div>

                        <div>
                            <h5 class="mb-1">
                                {{ $estudiante->user->nombre }} {{ $estudiante->user->apellido_paterno }}
                                {{ $estudiante->user->apellido_materno }}
                            </h5>

                            <div class="text-sm text-muted d-flex flex-wrap gap-3">
                                <span><i class="fas fa-envelope me-1"></i>{{ $estudiante->user->email ?? '—' }}</span>
                                <span><i class="fas fa-phone me-1"></i>{{ $estudiante->user->telefono ?? '—' }}</span>
                                <span><i class="fas fa-id-badge me-1"></i>{{ $estudiante->matricula ?? '—' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Roles --}}
                    @if (isset($estudiante->user) && method_exists($estudiante->user, 'getRoleNames'))
                        @php $roles = $estudiante->user->getRoleNames(); @endphp

                        <div class="text-end">
                            <div class="text-uppercase text-xs text-muted mb-1">Roles</div>

                            @if ($roles->isEmpty())
                                <span class="badge bg-secondary">Sin rol</span>
                            @else
                                @foreach ($roles as $rol)
                                    <span class="badge bg-primary ms-1">{{ $rol }}</span>
                                @endforeach
                            @endif
                        </div>
                    @endif

                </div>
            </div>

            <div class="card-body">

                {{-- Resumen rápido: horas --}}
                @php
                    $req = (int) ($estudiante->horas_requeridas ?? 0);
                    $act = (int) ($estudiante->horas_actuales ?? 0);
                    $pct = $req > 0 ? min(100, round(($act / $req) * 100)) : 0;
                @endphp

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-sm text-muted">Progreso de horas</span>
                        <span class="text-sm fw-bold">{{ $act }} / {{ $req }}
                            ({{ $pct }}%)</span>
                    </div>

                    <div class="progress" style="height:10px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $pct }}%;"></div>
                    </div>
                </div>

                {{-- 3 columnas visuales --}}
                <div class="row g-4">

                    {{-- Personales --}}
                    <div class="col-lg-4">
                        <div class="card h-100 border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-user me-2"></i>Personales</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="text-xs text-muted">Sexo</div>
                                    <div class="fw-bold">{{ $estudiante->sexo ?? '—' }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Teléfono del tutor</div>
                                    <div class="fw-bold">{{ $estudiante->telefono_tutor ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Escuela --}}
                    <div class="col-lg-4">
                        <div class="card h-100 border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Institución</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="text-xs text-muted">Escuela</div>
                                    <div class="fw-bold">{{ $estudiante->escuela ?? '—' }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">CCT</div>
                                    <div class="fw-bold">{{ $estudiante->cct ?? '—' }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Carrera</div>
                                    <div class="fw-bold">{{ $estudiante->carrera ?? '—' }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Área asignada</div>
                                    <div class="fw-bold">{{ $estudiante->area ?? '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dirección --}}
                    <div class="col-lg-4">
                        <div class="card h-100 border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Dirección</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="text-xs text-muted">Municipio</div>
                                    <div class="fw-bold">{{ $estudiante->municipio ?? '—' }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Colonia</div>
                                    <div class="fw-bold">{{ $estudiante->colonia ?? '—' }}</div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Calle</div>
                                    <div class="fw-bold">{{ $estudiante->calle ?? '—' }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <div class="text-xs text-muted">C.P.</div>
                                        <div class="fw-bold">{{ $estudiante->codigo_postal ?? '—' }}</div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-xs text-muted">No. Ext</div>
                                        <div class="fw-bold">{{ $estudiante->numero_exterior ?? '—' }}</div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="text-xs text-muted">No. Int</div>
                                    <div class="fw-bold">{{ $estudiante->numero_interior ?? '—' }}</div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
