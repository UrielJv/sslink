@extends('layouts.app')

@section('breadcrumb-parent', 'Administración')
@section('breadcrumb-current', 'Encargados')
@section('page-title', 'Edición de encargado')

@section('content')
    <form action="{{ route('encargados.update', $encargado->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card mb-4">

            {{-- HEADER --}}
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Encargados</h6>
                        <p class="text-sm mb-0 text-muted">Formulario de actualización para encargados</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('encargados.index') }}" class="btn btn-sm btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-sm btn-primary">
                            Actualizar
                        </button>
                    </div>
                </div>
            </div>

            {{-- BODY --}}
            @include('encargado.form')

        </div>

    </form>
@endsection
