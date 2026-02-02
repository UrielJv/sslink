@extends('layouts.app')

{{-- Nombre del tipo de usuario (Administracion, encargado, estudiante) --}}
@section('breadcrumb-parent', 'Administración')
{{-- Nombre de la accion en general (Reportes, tareas etc) --}}
@section('breadcrumb-current', 'Dashboard')
{{-- NNombre de accion en especifico (Registro, visualizacion etc) --}}
@section('page-title', 'Página de inicio')

@section('content')
    <div>
        <div class="col-lg-12 mb-lg-0 mb-4">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Estudiantes activos</p>
                                        <h5 class="font-weight-bolder">
                                            1,450
                                        </h5>
                                        {{-- <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+55%</span>
                                            since yesterday --}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="fa-solid fa-graduation-cap text-2xl opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">No. Encargados</p>
                                        <h5 class="font-weight-bolder">
                                            32
                                        </h5>
                                        {{-- <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+3%</span>
                                            since last week --}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="fa-solid fa-user-tie text-2xl opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">No. Instituciones</p>
                                        <h5 class="font-weight-bolder">
                                            18
                                        </h5>
                                        {{-- <p class="mb-0">
                                            <span class="text-danger text-sm font-weight-bolder">-2%</span>
                                            since last quarter --}}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="fa-solid fa-book text-2xl opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Áreas disponibles</p>
                                        <h5 class="font-weight-bolder">
                                            19
                                        </h5>
                                        {{-- <p class="mb-0">
                                            <span class="text-success text-sm font-weight-bolder">+5%</span> than last month
                                        </p> --}}
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="fa-solid fa-building text-2xl opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card z-index-2 h-100 p-2 mt-4">
                Inicio de dashboard
            </div>
        </div>
    </div>
@endsection
