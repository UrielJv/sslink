<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\EncargadoController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Mail;

// Ruta raiz
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Dashboard protegido
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    Route::resource('estudiantes', EstudianteController::class);
    Route::resource('encargados', EncargadoController::class);
    Route::get('estudiantes/{estudiante}/carta-aceptacion',[EstudianteController::class, 'cartaAceptacion'])
        ->name('estudiantes.cartaAceptacion');

    Route::get('estudiantes/{estudiante}/carta-termino',[EstudianteController::class, 'cartaTermino'])
        ->name('estudiantes.cartaTermino');

    Route::get('estudiantes/{estudiante}/documentacion',[EstudianteController::class, 'descargarDocumentacion'])
        ->name('estudiantes.documentacion');

    Route::get('/mi-informacion', [EstudianteController::class, 'info'])
        ->name('estudiante.info');

    Route::resource('asistencias', AsistenciaController::class);

    Route::get('estudiantes/{estudiante}/asistencias', [AsistenciaController::class, 'historial'])
        ->name('asistencias.historial');

    Route::get('/bitacora/{estudiante}',[AsistenciaController::class, 'descargarBitacora'])
        ->name('bitacora.descargar');

    Route::get('/reportes/crear/{estudiante}', [ReporteController::class, 'create'])
        ->name('reportes.create');

    Route::post('/reportes', [ReporteController::class, 'store'])
        ->name('reportes.store');

    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');

    Route::get('/reportes/encargado/crear', [ReporteController::class, 'createParaEncargado'])
        ->name('reportes.encargado.create');

    Route::post('/reportes/encargado', [ReporteController::class, 'storeParaEncargado'])
         ->name('reportes.encargado.store');

    //No quiten esta ruta pofi
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    // Detalle / info de reportes
    Route::get('/dashboard/reportes/info', [ReporteController::class, 'info'])
        ->name('reportes.info');

    Route::get('/encargado/mi-informacion', [EncargadoController::class, 'info'])
    ->name('encargado.info');

    Route::get('/admin/mi-informacion', function () {return view('admin.info');})
    ->name('admin.info');

});


