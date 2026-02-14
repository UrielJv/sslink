@extends('layouts.app')

@section('breadcrumb-parent', 'Administración')
@section('breadcrumb-current', 'Estudiantes')
@section('page-title', 'Página de inicio')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                {{-- Header con controles estilo Argon --}}
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h6 class="mb-0">Estudiantes</h6>
                            <p class="text-sm mb-0 text-muted">Listado de estudiantes registrados</p>
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

                            <a href="{{ route('estudiantes.create') }}" class="btn btn-sm btn-primary mb-0">
                                <i class="fas fa-plus me-1"></i> Nuevo
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body px-0 pt-3 pb-0">
                    <div class="table-responsive px-3 pb-3">
                        <table id="tablaEstudiantes" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Nombre
                                    </th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Matrícula</th>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Carrera
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        Horas</th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        Estado</th>
                                    <th
                                        class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($estudiantes as $estudiante)
                                    <tr>
                                        {{-- Nombre completo --}}
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $estudiante->user->nombre . ' ' . $estudiante->user->apellido_paterno . ' ' . $estudiante->user->apellido_materno }}
                                                    </h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $estudiante->user->email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        {{-- Matricula --}}
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $estudiante->matricula }}</p>
                                        </td>
                                        {{-- Carrera --}}
                                        <td>
                                            <p class="text-sm mb-0">{{ $estudiante->carrera }}</p>
                                        </td>
                                        {{-- Horas actuales --}}
                                        <td class="text-center">
                                            <span
                                                class="text-sm font-weight-bold">{{ $estudiante->horas_requeridas }}H</span>
                                        </td>
                                        {{-- Estado --}}
                                        <td class="text-center"><span
                                                class="badge badge-sm bg-gradient-success">Activo</span>
                                        </td>
                                        {{-- Acciones --}}
                                        <td class="align-middle text-center">
                                            <div class="actions d-flex justify-content-center align-items-center gap-3">

                                                <a href="{{ route('estudiantes.show', $estudiante->id) }}"
                                                    class="action-link text-info" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('estudiantes.edit', $estudiante->id) }}"
                                                    class="action-link text-warning" title="Editar">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <form action="{{ route('estudiantes.destroy', $estudiante->id) }}"
                                                    method="POST" class="m-0 p-0 action-form"
                                                    onsubmit="return confirm('¿Seguro que deseas eliminar este estudiante?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="action-btn text-danger" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>



                                    </tr>
                                @endforeach
                                {{-- FIN DEMO --}}
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
        $(function() {
            const dt = $('#tablaEstudiantes').DataTable({
                pageLength: 10,
                ordering: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                },
                columnDefs: [{
                        orderable: false,
                        targets: -1
                    }, // acciones
                ],
            });

            // Conectar controles Argon -> DataTables
            $('#dtSearch').on('keyup', function() {
                dt.search(this.value).draw();
            });

            $('#dtLength').on('change', function() {
                dt.page.len(parseInt(this.value, 10)).draw();
            });
        });
    </script>
@endpush
