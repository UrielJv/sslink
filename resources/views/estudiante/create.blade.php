@extends('layouts.app')

@section('breadcrumb-parent', 'Administración')
@section('breadcrumb-current', 'Estudiantes')
@section('page-title', 'Registro de prestador')

@section('content')
    <form id="formUsuario" action="{{ route('estudiantes.store') }}" method="POST">
        @csrf

        <div class="card mb-4">

            {{-- HEADER --}}
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Estudiantes</h6>
                        <p class="text-sm mb-0 text-muted">Formulario de registro para estudiantes</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('estudiantes.index') }}" class="btn btn-sm btn-secondary">
                            Cancelar
                        </a>

                        <button type="submit" id="btnSubmit" class="btn btn-sm btn-primary">
                            <span id="btnText">Guardar</span>
                            <span id="btnSpinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- BODY --}}
            @include('estudiante.form')

        </div>

    </form>

@endsection

@push('javascript')
    <script>
        document.getElementById('formUsuario').addEventListener('submit', function() {
            const btn = document.getElementById('btnSubmit');
            const text = document.getElementById('btnText');
            const spinner = document.getElementById('btnSpinner');

            btn.disabled = true;
            text.innerText = 'Guardando...';
            spinner.classList.remove('d-none');
        });
    </script>
@endpush
