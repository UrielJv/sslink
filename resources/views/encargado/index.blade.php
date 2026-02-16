@extends('layouts.app')

@section('breadcrumb-parent', 'Administración')
@section('breadcrumb-current', 'Encargados')
@section('page-title', 'Página de inicio')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">

                {{-- Header --}}
                <div class="card-header pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <h6 class="mb-0">Encargados</h6>
                            <p class="text-sm mb-0 text-muted">Listado de encargados registrados</p>
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
                                    placeholder="Buscar encargado...">
                            </div>

                            <a href="{{ route('encargados.create') }}" class="btn btn-sm btn-primary mb-0">
                                <i class="fas fa-plus me-1"></i> Nuevo
                            </a>
                        </div>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="card-body px-0 pt-3 pb-0">
                    <div class="table-responsive px-3 pb-3">
                        <table id="tablaEncargados" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Nombre
                                    </th>

                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Área
                                    </th>

                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                        Cargo
                                    </th>

                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        Estado
                                    </th>

                                    <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($encargados as $encargado)
                                    <tr>

                                        {{-- Nombre completo --}}
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ $encargado->user->nombre . ' ' . $encargado->user->apellido_paterno . ' ' . $encargado->user->apellido_materno }}
                                                    </h6>
                                                    <p class="text-xs text-secondary mb-0">
                                                        {{ $encargado->user->email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Área --}}
                                        <td>
                                            <p class="text-sm mb-0">{{ $encargado->area }}</p>
                                        </td>

                                        {{-- Cargo --}}
                                        <td>
                                            <p class="text-sm mb-0">{{ $encargado->cargo }}</p>
                                        </td>

                                        {{-- Estado --}}
                                        <td class="text-center">
                                            @if ($encargado->estatus)
                                                <span class="badge badge-sm bg-gradient-success">Activo</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Inactivo</span>
                                            @endif
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="align-middle text-center">
                                            <div class="actions d-flex justify-content-center align-items-center gap-3">

                                                <a href="{{ route('encargados.show', $encargado->id) }}"
                                                    class="action-link text-info" title="Visualizar">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('encargados.edit', $encargado->id) }}"
                                                    class="action-link text-warning" title="Editar">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <form action="{{ route('encargados.destroy', $encargado->id) }}"
                                                    method="POST" class="m-0 p-0 action-form"
                                                    onsubmit="return confirm('¿Seguro que deseas eliminar este encargado?')">
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
        const dt = $('#tablaEncargados').DataTable({
            pageLength: 10,
            ordering: true,
            autoWidth: false,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            columnDefs: [
                { orderable: false, targets: -1 },
            ],
        });

        $('#dtSearch').on('keyup', function() {
            dt.search(this.value).draw();
        });

        $('#dtLength').on('change', function() {
            dt.page.len(parseInt(this.value, 10)).draw();
        });
    });
</script>
@endpush
