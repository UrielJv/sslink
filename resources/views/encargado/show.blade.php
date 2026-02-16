@extends('layouts.app')

@section('breadcrumb-parent', 'Administración')
@section('breadcrumb-current', 'Encargados')
@section('page-title', 'Detalle de encargado')

@section('content')
    <div class="container-fluid py-4">

        {{-- Acciones --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('encargados.index') }}" class="btn btn-secondary">
                ← Volver
            </a>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('encargados.edit', $encargado->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i> Editar
                </a>

                <form class="m-0" action="{{ route('encargados.destroy', $encargado->id) }}" method="POST"
                    onsubmit="return confirm('¿Seguro que deseas eliminar este encargado?')">
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

            {{-- Header tipo perfil --}}
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">

                    <div class="d-flex align-items-center gap-3">

                        {{-- Avatar --}}
                        @php
                            $nombre = $encargado->user->nombre ?? '';
                            $ap = $encargado->user->apellido_paterno ?? '';
                            $iniciales = strtoupper(mb_substr($nombre, 0, 1) . mb_substr($ap, 0, 1));
                        @endphp

                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;font-weight:700;">
                            {{ $iniciales ?: 'E' }}
                        </div>

                        <div>
                            <h5 class="mb-1">
                                {{ $encargado->user->nombre }}
                                {{ $encargado->user->apellido_paterno }}
                                {{ $encargado->user->apellido_materno }}
                            </h5>

                            <div class="text-sm text-muted d-flex flex-wrap gap-3">
                                <span>
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ $encargado->user->email ?? '—' }}
                                </span>

                                <span>
                                    <i class="fas fa-phone me-1"></i>
                                    {{ $encargado->user->telefono ?? '—' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Roles --}}
                    @if (isset($encargado->user) && method_exists($encargado->user, 'getRoleNames'))
                        @php $roles = $encargado->user->getRoleNames(); @endphp

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

                <div class="row g-4">

                    {{-- Información laboral --}}
                    <div class="col-lg-6">
                        <div class="card h-100 border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-briefcase me-2"></i>
                                    Información laboral
                                </h6>
                            </div>

                            <div class="card-body">

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Área</div>
                                    <div class="fw-bold">
                                        {{ $encargado->area ?? '—' }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Cargo</div>
                                    <div class="fw-bold">
                                        {{ $encargado->cargo ?? '—' }}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Información del sistema --}}
                    <div class="col-lg-6">
                        <div class="card h-100 border">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">
                                    <i class="fas fa-cog me-2"></i>
                                    Información del sistema
                                </h6>
                            </div>

                            <div class="card-body">

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Fecha de registro</div>
                                    <div class="fw-bold">
                                        {{ optional($encargado->created_at)->format('d/m/Y') ?? '—' }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Última actualización</div>
                                    <div class="fw-bold">
                                        {{ optional($encargado->updated_at)->format('d/m/Y') ?? '—' }}
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="text-xs text-muted">Estado</div>
                                    <span class="badge bg-gradient-success">Activo</span>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
