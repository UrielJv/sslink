<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encargado;
use App\Models\Estudiante;
use App\Models\Asistencia;
use App\Models\Actividad;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BitacoraEstudianteExport;

class AsistenciaController extends Controller
{

    public function index()
    {
        $this->authorize('asistencia.ver');
        $encargado = auth()->user()->encargado;

        if (!$encargado) {
        abort(403, 'Este usuario no tiene perfil de encargado.');
    }

        $estudiantes = $encargado->estudiantes()
            ->with('user')
            ->where('estatus', '1   ')
            ->orderBy('matricula', 'asc')
            ->get();

        return view('asistencia.index', compact('estudiantes'));

    }


    public function create()
    {
         $this->authorize('asistencia.crear');
        $encargado = auth()->user()->encargado;

        $estudiantes = $encargado->estudiantes()
        ->orderBy('matricula')
        ->get();

        return view('asistencia.create', compact('estudiantes'));
    }

    public function store(Request $request)
    {
        $encargadoAuth = auth()->user()->encargado;
        if (!$encargadoAuth) abort(403);

        $request->validate([
            'encargado_id' => ['required','exists:encargados,id'],
            'estudiante_id' => ['required','exists:estudiantes,id'],
            'fecha' => ['required','date'],
            'estado' => ['required','in:presente,ausente,justificado'],
            'observaciones' => ['nullable','string'],

            'actividades' => ['required','array','min:1'],
            'actividades.*.nombre' => ['required','string'],
            'actividades.*.descripcion' => ['required','string'],
            'actividades.*.horas' => ['required','numeric','min:1'],
        ]);

        // Seguridad: no permitir que falsifiquen el encargado_id
        if ((int)$request->encargado_id !== (int)$encargadoAuth->id) {
            abort(403);
        }

        DB::transaction(function () use ($request, $encargadoAuth) {

            $totalHoras = collect($request->actividades)
                ->sum(fn($a) => (float)$a['horas']);

            $asistencia = Asistencia::create([
                'encargado_id' => $encargadoAuth->id,
                'estudiante_id' => $request->estudiante_id,
                'fecha' => $request->fecha,
                'estado' => $request->estado,
                'horas_cumplidas' => $totalHoras,
                'observaciones' => $request->observaciones,
            ]);

            foreach ($request->actividades as $actividad) {
                $asistencia->actividades()->create([
                    'nombre' => $actividad['nombre'],
                    'descripcion' => $actividad['descripcion'],
                    'horas' => $actividad['horas'],
                ]);
            }

            $estudiante = \App\Models\Estudiante::lockForUpdate()->findOrFail($request->estudiante_id);
            $estudiante->horas_actuales = (float)$estudiante->horas_actuales + $totalHoras;
            $estudiante->save();
        });

        return redirect()->route('asistencias.index')
            ->with('success', 'Asistencia registrada correctamente.');
    }

    public function show($id)
    {
         $this->authorize('asistencia.ver');
        $asistencia = Asistencia::with([
            'estudiante.user',
            'actividades'
        ])->findOrFail($id);

        // Seguridad: que solo el encargado dueño pueda verla
        $encargadoAuth = auth()->user()->encargado;

        if (!$encargadoAuth || $asistencia->encargado_id !== $encargadoAuth->id) {
            abort(403);
        }

        return view('asistencia.show', compact('asistencia'));
    }

    public function historial($estudianteId)
    {
         $this->authorize('asistencia.ver');
        $estudiante = \App\Models\Estudiante::with('user')->findOrFail($estudianteId);

        $asistencias = \App\Models\Asistencia::where('estudiante_id', $estudianteId)
            ->latest('fecha')
            ->get();

        return view('asistencia.historial', compact('estudiante', 'asistencias'));
    }

    public function descargarBitacora(Estudiante $estudiante)
    {
        return Excel::download(
            new BitacoraEstudianteExport($estudiante->id),
            'bitacora_'.$estudiante->id.'.xlsx'
        );
    }

}
