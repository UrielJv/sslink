<div class="card-body">

    {{-- Apartado de informacion personal --}}
    <p class="text-uppercase text-sm">Informacion personal</p>
    <div class="row mb-4">

        {{-- Nombre --}}
        <div class="form-group col-md-4">
            <label class="form-control-label">Nombre/s <span class="text-danger">*</span></label>
            <input name="nombre" class="form-control" type="text" placeholder="Juan Carlos" required
                value="{{ old('nombre', $encargado->user->nombre ?? '') }}">
        </div>

        {{-- Apellido paterno --}}
        <div class="form-group col-md-4">
            <label class="form-control-label">Apellido paterno <span class="text-danger">*</span></label>
            <input name="apellido_paterno" class="form-control" type="text" placeholder="Dominguez" required
                value="{{ old('apellido_paterno', $encargado->user->apellido_paterno ?? '') }}">
        </div>

        {{-- Apellido materno --}}
        <div class="form-group col-md-4">
            <label class="form-control-label">Apellido materno <span class="text-danger">*</span></label>
            <input name="apellido_materno" class="form-control" type="text" placeholder="Gutierrez" required
                value="{{ old('apellido_materno', $encargado->user->apellido_materno ?? '') }}">
        </div>

        {{-- Email --}}
        <div class="form-group col-md-6">
            <label class="form-control-label">Correo electronico <span class="text-danger">*</span></label>
            <input name="email" class="form-control" type="email" placeholder="correo@gmail.com" required
                value="{{ old('email', $encargado->user->email ?? '') }}">
        </div>

        {{-- Telefono --}}
        <div class="form-group col-md-6">
            <label class="form-control-label">Número de telefono <span class="text-danger">*</span></label>
            <input name="telefono" class="form-control" type="number" placeholder="7791320754" required
                value="{{ old('telefono', $encargado->user->telefono ?? '') }}">
        </div>

    </div>


    {{-- Apartado informacion del encargado --}}
    <p class="text-uppercase text-sm">Informacion del encargado</p>
    <div class="row">

        {{-- Area --}}
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Área asignada <span class="text-danger">*</span></label>
                <input name="area" class="form-control" type="text" placeholder="Recursos Humanos" required
                    value="{{ old('area', $encargado->area ?? '') }}">
            </div>
        </div>

        {{-- Cargo --}}
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">Cargo <span class="text-danger">*</span></label>
                <input name="cargo" class="form-control" type="text" placeholder="Supervisor"
                    required value="{{ old('cargo', $encargado->cargo ?? '') }}">
            </div>
        </div>

        {{-- Password --}}
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-control-label">
                    Contraseña asignada
                    @if (!isset($encargado))
                        <span class="text-danger">*</span>
                    @endif
                </label>

                <div class="input-group">
                    <input name="password" id="password" class="form-control" type="text"
                        placeholder="ABC12345" {{ isset($encargado) ? '' : 'required' }}>

                    <span class="input-group-text p-0">
                        <button class="btn btn-link mb-0 px-3" type="button" id="generarPassword">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </span>
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
@endpush
