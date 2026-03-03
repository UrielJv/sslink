@extends('layouts.app')

@section('breadcrumb-parent', 'Encargado')
@section('breadcrumb-current', 'Reportes')
@section('page-title', 'Subir reporte')

@section('content')
<div class="container-fluid py-4">

    {{-- Botón volver --}}
    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ← Volver
        </a>
    </div>

    <div class="row justify-content-center">
        {{-- MÁS ANCHO --}}
        <div class="col-lg-10 col-xl-9">

            <div class="card shadow-sm">

                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-flag me-2 text-danger"></i>
                        Nuevo reporte
                    </h5>
                    <p class="text-sm text-muted mb-0">
                        Registra un reporte relacionado con el estudiante
                    </p>
                </div>

                <div class="card-body">

                    {{-- FORMULARIO --}}
                    <form method="POST" action="{{ route('reportes.store') }}">
                        @csrf

                        {{-- ASUNTO + FECHA --}}
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Asunto</label>
                                <input type="text"
                                       name="asunto"
                                       class="form-control @error('asunto') is-invalid @enderror"
                                       placeholder="Ej. Incumplimiento de horario"
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

                        {{-- GRAVEDAD (SEPARADA, LIMPIA) --}}
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

                        {{-- CAMPOS OCULTOS --}}
                        <input type="hidden" name="receptor_id" value="{{ $estudiante->user_id }}">
                        <input type="hidden" name="emisor_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="tipo_emisor" value="encargado">
                        <input type="hidden" name="estudiante_id" value="{{ $estudiante->id }}">

                        {{-- BOTONES --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ url()->previous() }}"
                               class="btn btn-light d-flex align-items-center justify-content-center">
                                Cancelar
                            </a>

                            <button type="submit"
                                    class="btn btn-danger d-flex align-items-center justify-content-center">
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