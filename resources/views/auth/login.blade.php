@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <section class="min-vh-100 auth-split d-flex">
        <div class="container-fluid p-0">
            <div class="row g-0 min-vh-100">

                {{-- LEFT: IMAGE --}}
                <div class="col-lg-6 d-none d-lg-block auth-left">
                    {{-- Si quieres usar una imagen local: public/img/login.jpg --}}
                    <div class="auth-image" style="background-image: url('{{ asset('img/login.jpg') }}');">
                        <div class="auth-overlay"></div>

                        <div class="auth-left-content">

                            <div class="auth-badge">
                                Social Serve Link
                            </div>

                            <h2 class="fw-bold mt-4 mb-3">Control y seguimiento académico</h2>

                            <p class="mb-4 text-white-50">
                                Plataforma integral para la gestión del servicio social,
                                asistencias y actividades institucionales.
                            </p>

                            <div class="auth-features">

                                <div class="auth-feature-item">
                                    <i class="fas fa-user-check"></i>
                                    <div>
                                        <strong>Registro de asistencias</strong>
                                        <div class="text-white-50 small">
                                            Control diario de presencia y justificaciones.
                                        </div>
                                    </div>
                                </div>

                                <div class="auth-feature-item">
                                    <i class="fas fa-tasks"></i>
                                    <div>
                                        <strong>Gestión de actividades</strong>
                                        <div class="text-white-50 small">
                                            Registro detallado de tareas y horas acumuladas.
                                        </div>
                                    </div>
                                </div>

                                <div class="auth-feature-item">
                                    <i class="fas fa-chart-line"></i>
                                    <div>
                                        <strong>Seguimiento y reportes</strong>
                                        <div class="text-white-50 small">
                                            Información clara para encargados y administración.
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                {{-- RIGHT: FORM --}}
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center bg-white auth-right">
                    <div class="auth-form-wrap w-100">

                        <div class="text-center mb-4">
                            <div class="brand-mark mx-auto mb-3">
                                <img src="{{ asset('assets/img/logo_sslink_blanco.png') }}" alt="Logo"
                                    style="width: 50px">
                            </div>
                            <h4 class="mb-1 fw-bold">Iniciar sesión</h4>
                            <p class="text-muted mb-0">Ingresa tus datos para continuar</p>
                        </div>

                        <form id="formLogin" method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Correo electrónico</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-envelope text-muted"></i>
                                    </span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="tucorreo@ejemplo.com" required autofocus>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-2">
                                <label class="form-label fw-semibold">Contraseña</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white">
                                        <i class="fas fa-lock text-muted"></i>
                                    </span>

                                    <input id="password" type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" placeholder="••••••••"
                                        required>

                                    <button type="button" id="togglePassword"
                                        class="btn btn-outline-secondary border-start-0 d-flex align-items-center px-3"
                                        aria-label="Mostrar u ocultar contraseña">
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </div>

                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-3 mb-4">


                                {{-- si tienes reset password lo activas --}}
                                {{-- <a href="{{ route('password.request') }}" class="small text-decoration-none">¿Olvidaste tu contraseña?</a> --}}
                            </div>

                            {{-- Submit --}}
                            <button type="submit" id="btnSubmit" class="btn btn-primary btn-lg w-100 fw-semibold">
                                <span id="btnText">Entrar</span>
                                <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2"></span>
                            </button>

                            <div class="text-center mt-4 small text-muted">
                                © {{ date('Y') }} Social Serve Link
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        :root {
            --ssl-primary: #364865;
            /* color base (como tu header) */
            --ssl-primary-dark: #2f3f5a;
            /* para hover */
            --ssl-primary-soft: #4a5f82;
            /* para gradientes suaves */
            --ssl-bg: #f4f6fb;
            /* fondo claro */
        }

        .auth-split {
            background: var(--ssl-bg);
        }

        /* LEFT image side */
        .auth-left {
            position: relative;
        }

        .auth-image {
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .auth-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
                    rgba(54, 72, 101, .88),
                    rgba(54, 72, 101, .55));
        }

        .auth-left-content {
            position: absolute;
            left: 3rem;
            bottom: 3rem;
            right: 3rem;
            color: #fff;
            z-index: 2;
        }

        .auth-badge {
            display: inline-block;
            padding: .45rem .75rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .16);
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, .18);
        }

        /* RIGHT form side */
        .auth-right {
            padding: 2rem 1.25rem;
            background: #fff;
            position: relative;
            z-index: 5;
            transform: translateX(-5px);

            box-shadow:
                -15px 0 40px rgba(0, 0, 0, 0.08),
                -5px 0 15px rgba(0, 0, 0, 0.05);
        }

        .auth-form-wrap {
            max-width: 440px;
            padding: 1.25rem;
        }

        /* Brand mark */
        .brand-mark {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--ssl-primary), var(--ssl-primary-soft));
            color: #fff;
            font-weight: 800;
            letter-spacing: .5px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        }

        /* Inputs */
        .input-group-text {
            border-right: 0;
        }

        .input-group .form-control {
            border-left: 0;
        }

        .input-group .btn {
            border-left: 0;
        }

        .form-control:focus {
            box-shadow: none;
        }

        /* Button primary tuned to match your system */
        .btn-primary {
            background-color: var(--ssl-primary) !important;
            border-color: var(--ssl-primary) !important;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--ssl-primary-dark) !important;
            border-color: var(--ssl-primary-dark) !important;
        }

        /* Outline button for eye toggle */
        #togglePassword.btn-outline-secondary {
            color: var(--ssl-primary) !important;
            border-color: #d9dee8 !important;
            background: #fff !important;
        }

        #togglePassword.btn-outline-secondary:hover {
            border-color: #cfd6e4 !important;
            background: #f7f9fc !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Toggle password
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

        // Disable submit to avoid double click
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('formLogin');
            if (!form) return;

            form.addEventListener('submit', () => {
                const btnSubmit = document.getElementById('btnSubmit');
                const btnText = document.getElementById('btnText');
                const btnSpinner = document.getElementById('btnSpinner');

                if (btnSubmit) btnSubmit.disabled = true;
                if (btnText) btnText.innerText = 'Entrando...';
                if (btnSpinner) btnSpinner.classList.remove('d-none');
            });
        });
    </script>
@endpush
