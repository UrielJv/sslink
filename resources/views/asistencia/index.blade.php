@extends('layouts.app')

@section('breadcrumb-parent', 'Encargado')
@section('breadcrumb-current', 'Asistencias')
@section('page-title', 'Página de asistencias')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">

                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h6 class="mb-0">Estudiantes</h6>
                            <p class="text-sm mb-0 text-muted">Listado de estudiantes asigados</p>
                        </div>

                        <div class="d-flex gap-2 align-items-center">
                            <select id="dtLength" class="form-select form-select-sm" style="width: 90px;">
                                <option value="5">5</option>
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                            </select>

                            <div class="input-group input-group-sm" style="width: 260px;">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input id="dtSearch" type="text" class="form-control"
                                    placeholder="Buscar estudiante...">
                            </div>

                            <a href="{{ route('asistencias.create') }}" class="btn btn-sm btn-primary mb-0">
                                <i class="fas fa-plus me-1"></i> Registrar asistencia
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pt-3 pb-0">
                    <div class="table-responsive px-3 pb-3">
                        <table id="tablaAsistencias" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Nombre
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Matrícula
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Carrera
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        Horas
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        Estado
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($estudiantes as $estudiante)
                                    <tr>

                                        {{-- Nombre --}}
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $estudiante->user->nombre }}
                                                        {{ $estudiante->user->apellido_paterno }}
                                                        {{ $estudiante->user->apellido_materno }}
                                                    </h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $estudiante->user->email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Matrícula --}}
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">
                                                {{ $estudiante->matricula }}
                                            </p>
                                        </td>

                                        {{-- Carrera --}}
                                        <td>
                                            <p class="text-sm mb-0">
                                                {{ $estudiante->carrera }}
                                            </p>
                                        </td>

                                        {{-- Horas --}}
                                        <td class="text-center">
                                            <span class="text-sm font-weight-bold">
                                                {{ $estudiante->horas_actuales }} /
                                                {{ $estudiante->horas_requeridas }} H
                                            </span>
                                        </td>

                                        {{-- Estado --}}
                                        <td class="text-center">
                                            @if ($estudiante->servicio_terminado)
                                                <span class="badge badge-sm bg-gradient-success">
                                                    Finalizado
                                                </span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-warning">
                                                    En proceso
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="align-middle text-center">
                                            <a href="{{ route('asistencias.historial', $estudiante->id) }}"
                                                class="action-link text-info" title="Visualizar">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>



                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Inicializa DataTables
            const dt = $('#tablaAsistencias').DataTable({
                pageLength: parseInt($('#dtLength').val(), 10) || 10,
                lengthChange: false,
                searching: true,
                dom: 'rt<"d-flex justify-content-between align-items-center px-3 pb-3"ip>',
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json"
                },
                columnDefs: [{
                    orderable: false,
                    targets: [5]
                }]
            });

            // Tu buscador
            $('#dtSearch').on('keyup change', function() {
                dt.search(this.value).draw();
            });

            // Tu length
            $('#dtLength').on('change', function() {
                dt.page.len(parseInt(this.value, 10)).draw();
            });
        });
    </script>
@endpush
