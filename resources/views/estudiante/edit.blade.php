@extends('layouts.app')

@section('breadcrumb-parent', 'Administración')
@section('breadcrumb-current', 'Estudiantes')
@section('page-title', 'Edición de prestador')

@section('content')
    <form action="{{ route('estudiantes.update', $estudiante->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-4">

            {{-- HEADER --}}
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Estudiantes</h6>
                        <p class="text-sm mb-0 text-muted">Formulario de actualización para estudiantes</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-sm btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-sm btn-primary">
                            Actualizar
                        </button>
                    </div>
                </div>
            </div>

            {{-- BODY --}}
            @include('estudiante.form')

        </div>

    </form>
@endsection
