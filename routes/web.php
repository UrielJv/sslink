<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstudianteController;

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    Route::resource('estudiantes', EstudianteController::class);

});
