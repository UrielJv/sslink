@extends('layouts.app')

@section('breadcrumb-parent', 'Reportes')
@section('breadcrumb-current', 'Mis reportes')
@section('page-title', 'Mis reportes')

@section('content')
<div class="container-fluid py-4">

    <div class="card">
        <div class="card-header">

            <h6 class="mb-0">Reportes recibidos</h6>

            <p class="text-sm text-muted mb-0">
                Aquí se muestran los reportes que te han enviado
            </p>
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <p class="text-sm mb-0 text-muted">
            
        </p>
    </div>

    <div class="d-flex gap-2 align-items-center">
        {{-- Cantidad --}}
        <select id="dtLength" class="form-select form-select-sm" style="width: 90px;">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select>

        {{-- Buscador --}}
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

        <div class="card-body px-0 pt-3 pb-0">
            <div class="table-responsive px-3 pb-3">
                <table id="tablaReportes" class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                Asunto
                            </th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                Enviado por
                            </th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
                                Fecha
                            </th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                Descripción
                            </th>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">
    Gravedad
</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($reportes as $reporte)
                            <tr>
                                {{-- Asunto --}}
                                <td>
                                    <span class="text-sm fw-bold">
                                        {{ $reporte->asunto }}
                                    </span>
                                </td>

                                {{-- Emisor --}}
                                <td>
                                    <p class="text-sm mb-0">
                                        {{ $reporte->emisor->nombre }}
                                        {{ $reporte->emisor->apellido_paterno }}
                                    </p>
                                    <span class="text-xs text-muted">
                                        {{ ucfirst($reporte->emisor->rol) }}
                                    </span>
                                </td>

                                {{-- Fecha --}}
                                <td class="text-center">
                                    <span class="text-sm">
                                        {{ \Carbon\Carbon::parse($reporte->fecha)->format('d/m/Y') }}
                                    </span>
                                </td>

                                {{-- Descripción --}}
                                <td>
                                    <p class="text-sm mb-0">
                                        {{ $reporte->descripcion }}
                                    </p>
                                </td>
                                <td class="text-center">
                                 @if ($reporte->gravedad === 'alta')
                                    <span class="badge bg-danger">Alta</span>
                                 @elseif ($reporte->gravedad === 'media')
                                     <span class="badge bg-warning">Media</span>
                                @else
                                      <span class="badge bg-success">Baja</span>
                                 @endif
                                </td>
                            </tr>
                            
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    No tienes reportes aún
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function () {
        const table = $('#tablaReportes').DataTable({
            pageLength: 10,
            lengthChange: false,
            language: {
                search: "",
                info: "Mostrando _START_ a _END_ de _TOTAL_ reportes",
                paginate: {
                    next: "Siguiente",
                    previous: "Anterior"
                },
                zeroRecords: "No hay reportes disponibles"
            }
        });

        // Conectar select de cantidad
        $('#dtLength').on('change', function () {
            table.page.len(this.value).draw();
        });

        // Conectar buscador
        $('#dtSearch').on('keyup', function () {
            table.search(this.value).draw();
        });
    });
</script>
@endsection