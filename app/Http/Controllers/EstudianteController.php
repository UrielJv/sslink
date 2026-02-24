<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\Encargado;
use Illuminate\Validation\Rule;


class EstudianteController extends Controller
{

    public function index()
    {

        $estudiantes = Estudiante::with('user')
            ->where('estatus', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('estudiante.index', compact('estudiantes'));
    }


    public function create()
    {
        $encargados = Encargado::with('user')
        ->where('estatus', true)
        ->orderBy('id', 'desc')
        ->get();

        return view('estudiante.create', compact('encargados'));
    }


    public function store(Request $request)
    {
        // Validamos que los campos que vienen del formulario esten correctos
        $request->validate([
            // Usuario
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'telefono' => ['required', 'unique:users'],
            'password' => ['required', 'string', 'max:255'],

            // Estudiante
            'encargado_id' => ['required', 'exists:encargados,id'],
            'calle' => ['required', 'string', 'max:255'],
            'codigo_postal' => ['required', 'string', 'max:255'],
            'numero_exterior' => ['required', 'string', 'max:255'],
            'numero_interior' => ['nullable', 'string', 'max:255'],
            'colonia' => ['required', 'string', 'max:255'],
            'municipio' => ['required', 'string', 'max:255'],
            'sexo' => ['required', 'string', 'max:255'],
            'telefono_tutor' => ['required', 'string', 'max:255'],
            'matricula' => ['required', 'string', 'max:255'],
            'carrera' => ['required', 'string', 'max:255'],
            'escuela' => ['required', 'string', 'max:255'],
            'cct' => ['required', 'string', 'max:255'],
            'horas_requeridas' => ['required', 'integer'],
            'area' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date', 'max:255'],
            'fecha_fin' => ['nullable', 'date', 'max:255'],
        ]);

        try {

            DB::transaction(function () use ($request) {
            // Creamos el registro de usuario
            $user = User::create([
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'password' => bcrypt($request->password),
            ]);

            //asignamos el rol que tendra
            $user->assignRole('estudiante');

            //Obtener encargado
            $encargado = Encargado::findOrFail($request->encargado_id);

            //creamos el registro del estudiante
            Estudiante::create([
                'user_id' => $user->id,
                'encargado_id' => $encargado->id,
                'area' => $encargado->area,
                'matricula' => $request->matricula,
                'carrera' => $request->carrera,
                'escuela' => $request->escuela,
                'cct' => $request->cct,
                'horas_requeridas' => $request->horas_requeridas,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'calle' => $request->calle,
                'numero_exterior' => $request->numero_exterior,
                'numero_interior' => $request->numero_interior,
                'colonia' => $request->colonia,
                'codigo_postal' => $request->codigo_postal,
                'municipio' => $request->municipio,
                'sexo' => $request->sexo,
                'telefono_tutor' => $request->telefono_tutor,
            ]);
        });

            return redirect()
                ->route('estudiantes.index')
                ->with('success', 'Estudiante registrado correctamente.');


        } catch (\Exception $e) {

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Estudiante $estudiante)
    {
        $estudiante->load(['user', 'encargado.user']);

        return view('estudiante.show', compact('estudiante'));
    }


    public function edit(Estudiante $estudiante)
    {
        $estudiante->load('user');

        $encargados = Encargado::with('user')
        ->where('estatus', true)
        ->orderBy('id', 'desc')
        ->get();

        return view('estudiante.edit', compact('estudiante', 'encargados'));
    }


    public function update(Request $request, Estudiante $estudiante)
    {

        // cargamos relacion por si no viene del formulario
        $estudiante->load('user');

        $request->validate([
            // Usuario
            'nombre'            => ['required', 'string', 'max:255'],
            'apellido_paterno'  => ['required', 'string', 'max:255'],
            'apellido_materno'  => ['required', 'string', 'max:255'],
            'email'             => ['required', 'email', 'unique:users,email,' . $estudiante->user->id],
            'telefono'          => ['required', 'unique:users,telefono,' . $estudiante->user->id],
            'password'          => ['nullable', 'string'],

            // Estudiante
            'encargado_id' => ['required', 'exists:encargados,id'],
            'calle'             => ['required', 'string', 'max:255'],
            'codigo_postal'     => ['required', 'string', 'max:255'],
            'numero_exterior'   => ['required', 'string', 'max:255'],
            'numero_interior'   => ['nullable', 'string', 'max:255'],
            'colonia'           => ['required', 'string', 'max:255'],
            'municipio'         => ['required', 'string', 'max:255'],
            'sexo'              => ['required', 'string', 'max:255'],
            'telefono_tutor'    => ['required', 'string', 'max:255'],
            'matricula'         => ['required', 'string', 'max:255', 'unique:estudiantes,matricula,' . $estudiante->id],
            'carrera'           => ['required', 'string', 'max:255'],
            'escuela'           => ['required', 'string', 'max:255'],
            'cct'               => ['required', 'string', 'max:255'],
            'horas_requeridas'  => ['required', 'integer'],
            'area'              => ['required', 'string', 'max:255'],
            'fecha_inicio'      => ['required', 'date'],
            'fecha_fin'         => ['nullable', 'date'],
        ]);

        try {

        DB::transaction(function () use ($request, $estudiante) {

            // Creacion de data para user
            $userData = [
                'nombre' => $request->nombre,
                'apellido_paterno' => $request->apellido_paterno,
                'apellido_materno' => $request->apellido_materno,
                'email' => $request->email,
                'telefono' => $request->telefono,
            ];

            // Si viene la contraseña nueva se hashea y se mete a userData
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            // Actualizacion a user
            $estudiante->user->update($userData);

            //Obtener encargado nuevo
            $encargado = Encargado::findOrFail($request->encargado_id);

            // Actualizacion de estudiante
            $estudiante->update([
                'encargado_id' => $encargado->id,
                'area' => $encargado->area,
                'matricula' => $request->matricula,
                'carrera' => $request->carrera,
                'escuela' => $request->escuela,
                'cct' => $request->cct,
                'horas_requeridas' => $request->horas_requeridas,
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'calle' => $request->calle,
                'numero_exterior' => $request->numero_exterior,
                'numero_interior' => $request->numero_interior,
                'colonia' => $request->colonia,
                'codigo_postal' => $request->codigo_postal,
                'municipio' => $request->municipio,
                'sexo' => $request->sexo,
                'telefono_tutor' => $request->telefono_tutor,
            ]);

        });

            return redirect()
            ->route('estudiantes.index')
            ->with('success', 'Estudiante actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

    }


    public function destroy(Estudiante $estudiante)
    {
        try {

        DB::transaction(function () use ($estudiante) {

            // Desactivar estudiante
            $estudiante->update([
                'estatus' => false,
            ]);

            // Desactivar usuario relacionado (si existe)
            if ($estudiante->user) {
                $estudiante->user->update([
                    'estatus' => false,
                ]);

                // Quita los permisos del usuario pero dejenlo pendiente
                // $estudiante->user->syncRoles([]);
                // $estudiante->user->syncPermissions([]);
            }
        });

        return redirect()
            ->route('estudiantes.index')
            ->with('success', 'Estudiante borrado correctamente.');

        } catch (\Throwable $e) {
            return redirect()
                ->route('estudiantes.index')
                ->with('error', 'Ocurrió un error al desactivar el estudiante: ' . $e->getMessage());
        }
    }

    public function cartaAceptacion(Estudiante $estudiante)
    {
        $estudiante->load(['user', 'encargado.user']);

        $pdf = Pdf::loadView('pdf.carta_aceptacion', compact('estudiante'))
            ->setPaper('letter')
            ->setOptions([
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'dpi' => 96,
                'defaultFont' => 'DejaVu Serif',
            ]);

        return $pdf->download('Carta_Aceptacion_'.$estudiante->matricula.'.pdf');
    }

    public function cartaTermino(Estudiante $estudiante)
    {
        if (!$estudiante->servicio_terminado) {
            return back()->with('error', 'El estudiante aún no completa las horas requeridas.');
        }

        $estudiante->load(['user', 'encargado.user']);

        $pdf = Pdf::loadView('pdf.carta_termino', compact('estudiante'))
            ->setPaper('letter')
            ->setOptions([
                'isRemoteEnabled' => false,
                'isHtml5ParserEnabled' => true,
                'dpi' => 96,
                'defaultFont' => 'DejaVu Serif',
            ]);

        return $pdf->download('Carta_Termino_'.$estudiante->matricula.'.pdf');
    }

    public function descargarDocumentacion(Estudiante $estudiante)
    {
        $estudiante->load(['user', 'encargado.user']);

        if ($estudiante->servicio_terminado) {

            $zip = new ZipArchive();
            $fileName = 'Documentacion_'.$estudiante->matricula.'.zip';

            if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {

                $pdfAceptacion = Pdf::loadView('pdf.carta_aceptacion', compact('estudiante'))
                ->setPaper('letter')
                ->setOptions([
                    'isRemoteEnabled' => false,
                    'isHtml5ParserEnabled' => true,
                    'dpi' => 96,
                    'defaultFont' => 'DejaVu Serif',
                ])->output();

                $pdfTermino = Pdf::loadView('pdf.carta_termino', compact('estudiante'))
                    ->setPaper('letter')
                    ->setOptions([
                        'isRemoteEnabled' => false,
                        'isHtml5ParserEnabled' => true,
                        'dpi' => 96,
                        'defaultFont' => 'DejaVu Serif',
                    ])->output();

                $zip->addFromString('Carta_Aceptacion.pdf', $pdfAceptacion);
                $zip->addFromString('Carta_Termino.pdf', $pdfTermino);

                $zip->close();
            }

            return response()->download(public_path($fileName))->deleteFileAfterSend(true);
        }

        return $this->cartaAceptacion($estudiante);
    }
}
