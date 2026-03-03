@extends('layouts.app')

@section('breadcrumb-parent', 'Estudiante')
@section('breadcrumb-current', 'Reportes')
@section('page-title', 'Enviar reporte')

@section('content')
<div class="container-fluid py-4">

    {{-- Botón volver --}}
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Volver
        </a>
    </div>

    <div class="row justify-content-center">
        {{-- MISMO ANCHO --}}
        <div class="col-lg-10 col-xl-9">

            <div class="card shadow-sm">

                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-flag me-2 text-primary"></i>
                        Enviar reporte
                    </h5>
                    <p class="text-sm text-muted mb-0">
                        Reporte dirigido a tu encargado
                    </p>
                </div>

                <div class="card-body">

                    {{-- INFO ENCARGADO --}}
                    <div class="alert alert-light border mb-4">
                        <strong>Encargado:</strong>
                       {{ $estudiante->encargado?->user?->nombre ?? '—' }}
                            {{ $estudiante->encargado?->user?->apellido_paterno ?? '' }}
                    </div>

                    {{-- FORMULARIO --}}
                    <form method="POST" action="{{ route('reportes.encargado.store') }}">
                        @csrf

                        {{-- ASUNTO + FECHA --}}
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Asunto</label>
                                <input type="text"
                                       name="asunto"
                                       class="form-control @error('asunto') is-invalid @enderror"
                                       placeholder="Ej. Falta de comunicación"
                                       value="{{ old('asunto') }}"
                                       required>

                                @error('asunto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Fecha del reporte</label>
                                <input type="date"
                                       name="fecha"
                                       class="form-control @error('fecha') is-invalid @enderror"
                                       value="{{ old('fecha', now()->toDateString()) }}"
                                       required>

                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- DESCRIPCIÓN GRANDE --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Descripción del reporte
                            </label>
                            <textarea name="descripcion"
                                      rows="7"
                                      class="form-control @error('descripcion') is-invalid @enderror"
                                      placeholder="Describe detalladamente la situación..."
                                      required>{{ old('descripcion') }}</textarea>

                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- GRAVEDAD --}}
                        <div class="mb-4 col-md-4">
                            <label class="form-label fw-bold">Gravedad del reporte</label>
                            <select name="gravedad"
                                    class="form-select @error('gravedad') is-invalid @enderror"
                                    required>
                                <option value="">Selecciona una opción</option>
                                <option value="baja" {{ old('gravedad') == 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('gravedad') == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('gravedad') == 'alta' ? 'selected' : '' }}>Alta</option>
                            </select>

                            @error('gravedad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- BOTONES --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ url()->previous() }}"
                               class="btn btn-light d-flex align-items-center justify-content-center">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="btn btn-primary d-flex align-items-center justify-content-center">
                                <i class="fas fa-paper-plane me-1"></i>
                                Enviar reporte
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection