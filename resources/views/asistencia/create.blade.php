@extends('layouts.app')

@section('breadcrumb-parent', 'Encargado')
@section('breadcrumb-current', 'Estudiantes')
@section('page-title', 'Registro de asistencia')

@section('content')
    <form action="{{ route('asistencias.store') }}" method="POST" id="formAsistencia">
        @csrf

        <input type="hidden" name="encargado_id" value="{{ auth()->user()->encargado->id }}">

        {{-- Card: Datos de asistencia --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h6 class="mb-0">Datos de asistencia</h6>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Estudiante</label>
                        <select name="estudiante_id" class="form-select" required>
                            <option value="">Selecciona...</option>
                            @foreach ($estudiantes as $e)
                                <option value="{{ $e->id }}">
                                    {{ $e->user->nombre }} {{ $e->user->apellido_paterno ?? '' }}
                                    {{ $e->user->apellido_materno ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="presente">Presente</option>
                            <option value="ausente">Ausente</option>
                            <option value="justificado">Justificado</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observaciones (opcional)</label>
                        <textarea name="observaciones" class="form-control" rows="3" placeholder="Ej. Llegó tarde, justificante, etc."></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Actividades --}}
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Actividades</h6>
                <div class="text-muted small">
                    Total horas: <strong><span id="totalHoras">0</span></strong>
                </div>
            </div>

            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label">Título</label>
                        <input type="text" id="act_nombre" class="form-control" placeholder="Ej. Documentación" />
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Horas</label>
                        <input type="number" id="act_horas" class="form-control" min="0" step="1" />
                    </div>

                    <div class="col-md-3 d-grid">
                        <label class="form-label d-none d-md-block">&nbsp;</label>
                        <button type="button" class="btn btn-primary" id="btnAgregarActividad">
                            <i class="ni ni-fat-add me-1"></i> Agregar
                        </button>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Descripción</label>
                        <textarea id="act_descripcion" class="form-control" rows="2" placeholder="Describe la actividad realizada..."></textarea>
                    </div>
                </div>

                <div class="table-responsive mt-4">
                    <table class="table align-middle">
                        <thead class="thead-light">
                            <tr>
                                <th>Actividad</th>
                                <th style="width: 120px;">Horas</th>
                                <th style="width: 120px;" class="text-end">Acciones</th>
                            </tr>
                        </thead>

                        <tbody id="tablaActividadesBody">
                            <tr id="rowEmpty">
                                <td colspan="3" class="text-center text-muted py-4">
                                    Aún no agregas actividades.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">

                    <a href="{{ route('asistencias.index') }}" class="btn btn-outline-secondary">
                        <i class="ni ni-bold-left me-1"></i> Cancelar
                    </a>

                    <button type="submit" class="btn btn-success" id="btnSubmit">
                        <span id="btnText"><i class="ni ni-check-bold me-1"></i> Guardar asistencia</span>
                        <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2"></span>
                    </button>

                </div>
            </div>
        </div>
    </form>
@endsection

@push('javascript')
    <script>
        const actividades = [];
        const tbody = document.getElementById('tablaActividadesBody');
        const totalHorasEl = document.getElementById('totalHoras');
        const form = document.getElementById('formAsistencia');
        const btnAgregar = document.getElementById('btnAgregarActividad');

        function render() {
            const rowEmpty = document.getElementById('rowEmpty');
            if (rowEmpty) rowEmpty.remove();

            tbody.innerHTML = '';
            let total = 0;

            actividades.forEach((a, i) => {
                total += Number(a.horas || 0);

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <div class="fw-semibold">${a.nombre}</div>
                        <div class="text-muted small">${a.descripcion ?? ''}</div>
                    </td>
                    <td>${a.horas}</td>
                    <td class="text-end">
                        <button type="button" class="btn btn-danger btn-sm" data-index="${i}">Quitar</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            totalHorasEl.textContent = total;
        }

        btnAgregar.addEventListener('click', () => {
            const nombre = document.getElementById('act_nombre').value.trim();
            const descripcion = document.getElementById('act_descripcion').value.trim();
            const horas = document.getElementById('act_horas').value;

            if (!nombre) return alert('Pon un título.');
            if (!descripcion) return alert('Pon una descripción.');
            if (!horas || Number(horas) <= 0) return alert('Pon horas válidas.');

            actividades.push({
                nombre,
                descripcion,
                horas
            });

            document.getElementById('act_nombre').value = '';
            document.getElementById('act_descripcion').value = '';
            document.getElementById('act_horas').value = '';

            render();
        });

        tbody.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-index]');
            if (!btn) return;

            const i = Number(btn.getAttribute('data-index'));
            actividades.splice(i, 1);

            if (actividades.length === 0) {
                tbody.innerHTML = `
                    <tr id="rowEmpty">
                        <td colspan="3" class="text-center text-muted py-4">
                            Aún no agregas actividades.
                        </td>
                    </tr>
                `;
                totalHorasEl.textContent = 0;
                return;
            }

            render();
        });

        form.addEventListener('submit', (e) => {
            form.querySelectorAll('input[name^="actividades["]').forEach(el => el.remove());

            if (actividades.length === 0) {
                e.preventDefault();
                return alert('Agrega al menos una actividad.');
            }

            actividades.forEach((a, i) => {
                ['nombre', 'descripcion', 'horas'].forEach((f) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `actividades[${i}][${f}]`;
                    input.value = a[f] ?? '';
                    form.appendChild(input);
                });
            });

            const btnSubmit = document.getElementById('btnSubmit');
            const btnText = document.getElementById('btnText');
            const btnSpinner = document.getElementById('btnSpinner');

            btnSubmit.disabled = true;
            btnText.innerHTML = 'Guardando...';
            btnSpinner.classList.remove('d-none');
        });
    </script>
@endpush
