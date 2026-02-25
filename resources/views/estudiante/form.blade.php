<div class="card-body">
    {{-- Apartado de informacion personal --}}
    <p class="text-uppercase text-sm">Informacion personal</p>
    <div class="row mb-4">

        {{-- Nombres --}}
        <div class="form-group col-md-4">
            <label for="example-text-input" class="form-control-label">Nombre/s <span class="text-danger">*</span></label>
            <input name="nombre" class="form-control" type="text" placeholder="Juan carlos" required
                value="{{ old('nombre', $estudiante->user->nombre ?? '') }}">
        </div>

        {{-- Apellido paterno --}}
        <div class="form-group col-md-4">
            <label for="example-text-input" class="form-control-label">Apellido paterno <span
                    class="text-danger">*</span></label>
            <input name="apellido_paterno" class="form-control" type="text" placeholder="Dominguez" required
                value="{{ old('apellido_paterno', $estudiante->user->apellido_paterno ?? '') }}">
        </div>

        {{-- Apellido materno --}}
        <div class="form-group col-md-4">
            <label for="example-text-input" class="form-control-label">Apellido materno <span
                    class="text-danger">*</span></label>
            <input name="apellido_materno" class="form-control" type="text" placeholder="Gutierrez" required
                value="{{ old('apellido_materno', $estudiante->user->apellido_materno ?? '') }}">
        </div>

        {{-- Correo electronico --}}
        <div class="form-group col-md-8">
            <label for="example-text-input" class="form-control-label">Correo electronico <span
                    class="text-danger">*</span></label>
            <input name="email" class="form-control" type="email" placeholder="juancarlos@gmail.com" required
                value="{{ old('email', $estudiante->user->email ?? '') }}">
        </div>

        {{-- Sexo --}}
        <div class="form-group col-md-4">
            <label class="form-control-label">Sexo <span class="text-danger">*</span></label>
            <select class="form-control" name="sexo" required>
                <option value="" disabled {{ old('sexo', $estudiante->sexo ?? '') == '' ? 'selected' : '' }}>
                    Selecciona</option>
                <option value="Hombre" {{ old('sexo', $estudiante->sexo ?? '') == 'Hombre' ? 'selected' : '' }}>Hombre
                </option>
                <option value="Mujer" {{ old('sexo', $estudiante->sexo ?? '') == 'Mujer' ? 'selected' : '' }}>Mujer
                </option>
            </select>
        </div>

        {{-- Numero de telefono --}}
        <div class="form-group col-md-4">
            <label for="example-text-input" class="form-control-label">Número de telefono <span
                    class="text-danger">*</span></label>
            <input name="telefono" class="form-control" type="number" placeholder="7791320754" required
                value="{{ old('telefono', $estudiante->user->telefono ?? '') }}">
        </div>

        {{-- Numero de telefono del tutor --}}
        <div class="form-group col-md-4">
            <label for="example-text-input" class="form-control-label">Número telefonico de tutor<span
                    class="text-danger">*</span></label>
            <input name="telefono_tutor" class="form-control" type="number" placeholder="5572865421"
                value="{{ old('telefono_tutor', $estudiante->telefono_tutor ?? '') }}">
        </div>

        {{-- Codigo postal --}}
        <div class="form-group col-md-4">
            <label for="example-text-input" class="form-control-label">Codigo postal<span
                    class="text-danger">*</span></label>
            <input name="codigo_postal" class="form-control" type="number" placeholder="43815" required
                value="{{ old('codigo_postal', $estudiante->codigo_postal ?? '') }}">
        </div>

        {{-- Colonia --}}
        <div class="form-group col-md-4">
            <label for="example-text-input" class="form-control-label">Colonia<span class="text-danger">*</span></label>
            <input name="colonia" class="form-control" type="text" placeholder="Fraccionamiento Marbella" required
                value="{{ old('colonia', $estudiante->colonia ?? '') }}">
        </div>

        {{-- Calle --}}
        <div class="form-group col-md-8">
            <label for="example-text-input" class="form-control-label">Calle <span class="text-danger">*</span></label>
            <input name="calle" class="form-control" type="text" placeholder="Estaladita" required
                value="{{ old('calle', $estudiante->calle ?? '') }}">
        </div>

        {{-- Municipio --}}
        <div class="form-group col-md-6">
            <label for="example-text-input" class="form-control-label">Municipio <span
                    class="text-danger">*</span></label>
            <input name="municipio" class="form-control" type="text" placeholder="Tizayuca" required
                value="{{ old('municipio', $estudiante->municipio ?? '') }}">
        </div>

        {{-- Numero exterior --}}
        <div class="form-group col-md-3">
            <label for="example-text-input" class="form-control-label">Número Exterior <span
                    class="text-danger">*</span></label>
            <input name="numero_exterior" class="form-control" type="number" placeholder="102" required
                value="{{ old('numero_exterior', $estudiante->numero_exterior ?? '') }}">
        </div>

        {{-- Numero interior --}}
        <div class="form-group col-md-3">
            <label for="example-text-input" class="form-control-label">Número Interior</label>
            <input name="numero_interior" class="form-control" type="number" placeholder="12"
                value="{{ old('numero_interior', $estudiante->numero_interior ?? '') }}">
        </div>


    </div>

    {{-- Apartado de informacion escolar --}}
    <p class="text-uppercase text-sm">Informacion escolar</p>
    <div class="row">

        {{-- Escuela (G¿Hacer select) --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Institucion de procedencia <span
                        class="text-danger">*</span></label>
                <input name="escuela" class="form-control" type="text"
                    placeholder="Colegio de Estudios Cientificos y Tecnologicos del Estado de Hidalgo" required
                    value="{{ old('escuela', $estudiante->escuela ?? '') }}">
            </div>
        </div>

        {{-- Carrera (Hacer select dependiendo de la institucion) --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Carrera actual<span
                        class="text-danger">*</span></label>
                <input name="carrera" class="form-control" type="text" placeholder="Administracion de empresas"
                    required value="{{ old('carrera', $estudiante->carrera ?? '') }}">
            </div>
        </div>

        {{-- Matricula --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Matricula <span
                        class="text-danger">*</span></label>
                <input name="matricula" class="form-control" type="text" placeholder="2524260072" required
                    value="{{ old('matricula', $estudiante->matricula ?? '') }}">
            </div>
        </div>

        {{-- CCT --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">CCT <span
                        class="text-danger">*</span></label>
                <input name="cct" class="form-control" type="text" placeholder="15EPR" required
                    value="{{ old('cct', $estudiante->cct ?? '') }}">
            </div>
        </div>

        {{-- Encargado --}}
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-control-label">
                    Encargado{{-- <span class="text-danger">*</span> --}}
                </label>

                <select name="encargado_id" id="encargadoSelect" class="form-control" required>
                    <option value="" disabled
                        {{ old('encargado_id', $estudiante->encargado_id ?? '') == '' ? 'selected' : '' }}>
                        Selecciona
                    </option>

                    @foreach ($encargados as $encargado)
                        <option value="{{ $encargado->id }}" data-area="{{ $encargado->area }}"
                            {{ old('encargado_id', $estudiante->encargado_id ?? '') == $encargado->id ? 'selected' : '' }}>
                            {{ $encargado->user->nombre ?? 'Sin nombre' }}
                            {{ $encargado->user->apellido_paterno ?? '' }}
                            {{ $encargado->user->apellido_materno ?? '' }}
                            ({{ $encargado->cargo }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Area --}}
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-control-label">
                    Área asignada{{-- <span class="text-danger">*</span> --}}
                </label>
                <input name="area" id="areaInput" class="form-control" type="text" placeholder="Cabildo"
                    required readonly value="{{ old('area', $estudiante->area ?? '') }}">
            </div>
        </div>

        {{-- Horas requeridas --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Total de horas requeridas <span
                        class="text-danger">*</span></label>
                <input name="horas_requeridas" class="form-control" type="number" placeholder="480" required
                    value="{{ old('horas_requeridas', $estudiante->horas_requeridas ?? '') }}">
            </div>
        </div>

        {{-- Contraseña asiganda --}}
        <div class="col-md-4">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Contraseña asignada
                    @if (!isset($estudiante))
                        <span class="text-danger">*</span>
                    @endif
                </label>
                <div class="input-group">
                    <input name="password" id="password" class="form-control" type="text"
                        placeholder="WSP027HA" {{ isset($estudiante) ? '' : 'required' }}>

                    <span class="input-group-text p-0">
                        <button class="btn btn-link mb-0 px-3" type="button" id="generarPassword">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>

        {{-- Fecha de inicio --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Fecha de inicio <span
                        class="text-danger">*</span></label>
                <input name="fecha_inicio" class="form-control" type="date" placeholder="Cabildo" required
                    value="{{ old('fecha_inicio', optional($estudiante->fecha_inicio ?? null)->format('Y-m-d')) }}">
            </div>
        </div>

        {{-- Fecha de finalizacion --}}
        <div class="col-md-6">
            <div class="form-group">
                <label for="example-text-input" class="form-control-label">Fecha de finalizacion <span
                        class="text-danger">*</span></label>
                <input name="fecha_fin" class="form-control" type="date" placeholder="Cabildo"
                    value="{{ old('fecha_fin', optional($estudiante->fecha_fin ?? null)->format('Y-m-d')) }}">
            </div>
        </div>

    </div>
</div>
</div>

@push('scripts')
    <script>
        document.getElementById('generarPassword').addEventListener('click', function() {
            const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            let password = '';

            for (let i = 0; i < 8; i++) {
                password += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
            }

            document.getElementById('password').value = password;
        });
    </script>

    <script>
        const encargadoSelect = document.getElementById('encargadoSelect');
        const areaInput = document.getElementById('areaInput');

        function setAreaFromEncargado() {
            const option = encargadoSelect.options[encargadoSelect.selectedIndex];
            const area = option ? option.getAttribute('data-area') : '';
            areaInput.value = area || '';
        }

        if (encargadoSelect && areaInput) {
            encargadoSelect.addEventListener('change', setAreaFromEncargado);

            // Para que funcione al cargar en "editar" o si viene old()
            window.addEventListener('load', setAreaFromEncargado);
        }
    </script>
@endpush
