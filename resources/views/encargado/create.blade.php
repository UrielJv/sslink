@extends('layouts.app')

@section('breadcrumb-parent', 'Administración')
@section('breadcrumb-current', 'Encargados')
@section('page-title', 'Registro de encargado')

@section('content')
    <form action="{{ route('encargados.store') }}" method="POST">
        @csrf

        <div class="card mb-4">

            {{-- HEADER --}}
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Encargados</h6>
                        <p class="text-sm mb-0 text-muted">Formulario de registro para encargados</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('encargados.index') }}" class="btn btn-sm btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-sm btn-primary">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>

            {{-- BODY --}}
            @include('encargado.form', ['encargado' => new \App\Models\Encargado])

        </div>

    </form>
@endsection
