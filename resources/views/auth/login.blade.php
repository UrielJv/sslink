@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <section class="d2c_login_system d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-10 offset-xl-1">
                    <div class="row">
                        <div class="col-lg-6 pe-lg-0 d2c_login_left">
                            <div class="d2c_login_wrapper">
                                <div class="text-center mb-4">
                                    <h4 class="text-capitalize">Social Serve Link</h4>
                                    <p class="text-muted">
                                        Bienvenido
                                    </p>
                                </div>

                                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                    @csrf

                                    {{-- Email --}}
                                    <div class="mb-3">
                                        <label class="form-label">Correo Electronico</label>
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Ingresa tu correo electronico" required autofocus>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Password --}}
                                    <div class="mb-3">
                                        <label class="form-label">Contraseña</label>
                                        <div class="input-group">
                                            <input id="password" type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Ingresa tu contraseña" required>
                                            <button type="button" id="togglePassword"
                                                class="btn border-0 bg-transparent d-flex align-items-center justify-content-center px-3">
                                                <i class="fas fa-eye-slash text-1xl"></i>
                                            </button>

                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="mb-3 mt-5">
                                        <button type="submit" class="btn btn-primary w-100 text-uppercase">
                                            Iniciar Sesión
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        {{-- login right image --}}
                        <div class="col-lg-6 d2c_login_right_image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const btn = document.getElementById('togglePassword');
        const input = document.getElementById('password');

        if (btn && input) {
            btn.addEventListener('click', () => {
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                const icon = btn.querySelector('i');
                if (icon) {
                    icon.classList.toggle('fa-eye-slash', !isPassword);
                    icon.classList.toggle('fa-eye', isPassword);
                }
            });
        }
    </script>
@endpush
