@extends('layouts.app')

@section('breadcrumb-parent', 'Dashboard')
@section('breadcrumb-current', 'Reportes')
@section('page-title', 'Todos los reportes')

@section('content')
<div class="container-fluid py-4">

    <div class="card shadow-sm">

        {{-- HEADER --}}
        <div class="card-header pb-0">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2 text-primary"></i>
                        Reportes registrados
                    </h5>
                    <p class="text-sm text-muted mb-0">
                        Listado general de todos los reportes del sistema
                    </p>
                </div>

                {{-- CONTROLES DATATABLE --}}
                <div class="d-flex gap-2 align-items-center">
                    <select id="dtLength" class="form-select form-select-sm" style="width: 90px;">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>

                    <div class="input-group input-group-sm" style="width: 260px;">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input id="dtSearch" type="text" class="form-control"
                               placeholder="Buscar reporte...">
                    </div>
                </div>
            </div>
        </div>

        {{-- BODY --}}
        <div class="card-body px-0 pt-3 pb-0">
            <div class="table-responsive px-3 pb-3">
                <table id="tablaReportes" class="table table-hover align-items-center mb-0">

                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                Emisor → Receptor
                            </th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                Asunto
                            </th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                Descripción
                            </th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                Fecha
                            </th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                Gravedad
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($reportes as $reporte)
                            <tr>

                                {{-- EMISOR → RECEPTOR --}}
                                <td>
                                    <div class="text-sm">
                                        <strong>{{ $reporte->emisor->nombre ?? 'N/A' }}</strong>
                                        →
                                        <strong>{{ $reporte->receptor->nombre ?? 'N/A' }}</strong>
                                    </div>
                                </td>

                                {{-- ASUNTO --}}
                                <td>
                                    <span class="fw-bold text-sm">
                                        {{ $reporte->asunto }}
                                    </span>
                                </td>

                                {{-- DESCRIPCIÓN --}}
                                <td style="max-width: 320px;">
                                    <p class="text-sm mb-0 text-truncate"
                                       title="{{ $reporte->descripcion }}">
                                        {{ $reporte->descripcion }}
                                    </p>
                                </td>

                                {{-- FECHA --}}
                                <td class="text-center">
                                    <span class="text-sm">
                                        {{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}
                                    </span>
                                </td>

                                {{-- GRAVEDAD --}}
                                <td class="text-center">
                                    @if ($reporte->gravedad === 'alta')
                                        <span class="badge bg-danger">Alta</span>
                                    @elseif ($reporte->gravedad === 'media')
                                        <span class="badge bg-warning text-dark">Media</span>
                                    @else
                                        <span class="badge bg-success">Baja</span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        const table = $('#tablaReportes').DataTable({
            paging: true,
            info: false,
            ordering: true,
            lengthChange: false,
            pageLength: 10,
            language: {
                search: "",
                searchPlaceholder: "Buscar reporte...",
                paginate: {
                    previous: "‹",
                    next: "›"
                },
                zeroRecords: "No se encontraron reportes",
                emptyTable: "No hay reportes registrados"
            }
        });

        // Buscador personalizado
        $('#dtSearch').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Selector de cantidad
        $('#dtLength').on('change', function () {
            table.page.len(this.value).draw();
        });

    });
</script>
@endpush