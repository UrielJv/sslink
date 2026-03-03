<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encargado;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Asistencia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
    $totalEncargados = Encargado::count();
    $totalEstudiantes = Estudiante::count();
    $estudiantesActivos = Estudiante::where('estatus', 1)->count();

    // Estudiantes por mes (últimos 6)
    $estudiantesPorMes = Estudiante::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes, COUNT(*) as total")
        ->where('created_at', '>=', now()->subMonths(5)->startOfMonth())
        ->groupBy('mes')
        ->orderBy('mes')
        ->pluck('total', 'mes');

    // labels bonitos (Ene 2026, Feb 2026...)
    $labelsMeses = collect(range(0, 5))->map(function ($i) {
        return now()->subMonths(5 - $i)->translatedFormat('M Y');
    });

    // data alineada con esos 6 meses aunque falte alguno
    $dataMeses = collect(range(0, 5))->map(function ($i) use ($estudiantesPorMes) {
        $key = now()->subMonths(5 - $i)->format('Y-m');
        return (int) ($estudiantesPorMes[$key] ?? 0);
    });

    $estudiantesInactivos = Estudiante::where('estatus', 0)->count();

    $ultimosEstudiantes = Estudiante::with('user')
    ->latest()
    ->take(5)
    ->get();

    // Apartado de asistencias
    $asistHoy = Asistencia::whereDate('created_at', today())->count();
    $asistSemana = Asistencia::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
    $asistMes = Asistencia::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();

    $asistenciasPorDia = Asistencia::selectRaw("DATE(created_at) as dia, COUNT(*) as total")
        ->where('created_at', '>=', now()->subDays(13)->startOfDay())
        ->groupBy('dia')
        ->orderBy('dia')
        ->pluck('total', 'dia');

    $labelsAsist = collect(range(0, 13))->map(fn($i) => now()->subDays(13 - $i)->translatedFormat('d M'));
    $dataAsist = collect(range(0, 13))->map(function ($i) use ($asistenciasPorDia) {
        $key = now()->subDays(13 - $i)->toDateString();
        return (int) ($asistenciasPorDia[$key] ?? 0);
    });

    $ultimasAsistencias = Asistencia::with(['estudiante.user'])
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'totalUsuarios',
        'totalEncargados',
        'totalEstudiantes',
        'estudiantesActivos',
        'estudiantesInactivos',
        'ultimosEstudiantes',
        'labelsMeses',
        'dataMeses',
        'labelsAsist',
        'dataAsist',
        'asistHoy',
        'asistSemana',
        'asistMes',
        'ultimasAsistencias',
    ));
    }
}
