<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{
    // Vista para crear reporte (desde encargado hacia estudiante)
    public function create($estudianteId)
    {
        $estudiante = Estudiante::with('user')->findOrFail($estudianteId);

        return view('reportes.create', compact('estudiante'));
    }

    // Guardar reporte
   public function store(Request $request)
{
    $request->validate([
        'asunto' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'gravedad' => 'required|in:baja,media,alta',
        'receptor_id' => 'required|exists:users,id',
    ]);

    Reporte::create([
        'asunto'      => $request->asunto,
        'descripcion' => $request->descripcion,
        'gravedad'    => $request->gravedad,
        'fecha'       => now(),
        'emisor_id'   => auth()->id(),
        'receptor_id' => $request->receptor_id,
    ]);

 return redirect()
        ->route('reportes.index') // no borrar la linea comentada por si no funciona
        ->with('success', 'Reporte enviado correctamente');
    //return redirect()->back()->with('success', 'Reporte enviado correctamente');
}
    public function index()
{
    $reportes = Reporte::with(['emisor'])
        ->where('receptor_id', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

    return view('reportes.index', compact('reportes'));
}

public function createParaEncargado()
{
    $user = Auth::user();

    // Estudiante del usuario logueado
    $estudiante = Estudiante::where('user_id', $user->id)->firstOrFail();

    // Encargado (MODELO Encargado)
    $encargado = $estudiante->encargado;

    return view('reportes.create_encargado', compact('estudiante', 'encargado'));
}

 public function storeParaEncargado(Request $request)
    {
        $request->validate([
            'asunto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'gravedad' => 'required|in:baja,media,alta',
        ]);

        $user = Auth::user();

        $estudiante = Estudiante::where('user_id', $user->id)->firstOrFail();

        Reporte::create([
            'asunto' => $request->asunto,
            'descripcion' => $request->descripcion,
            'gravedad' => $request->gravedad,
            'fecha' => now(),

            // Emisor → estudiante (user)
            'emisor_id' => $user->id,

            // Receptor → encargado (user)
            'receptor_id' => $estudiante->encargado->user_id,
        ]);

        return redirect()->route('reportes.index')
            ->with('success', 'Reporte enviado correctamente');
    }
public function adminIndex()
{
    $reportes = Reporte::with(['emisor', 'receptor'])
        ->orderBy('fecha', 'desc')
        ->get();

    return view('reportes.info', compact('reportes'));
}
public function info()
{
    $reportes = Reporte::with(['emisor', 'receptor'])->latest()->get();

    return view('reportes.info', compact('reportes'));
}
}