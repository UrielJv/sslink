<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Encargado;

class EncargadoController extends Controller
{

    public function index()
    {
        $encargados = Encargado::with('user')
            ->where('estatus', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('encargado.index', compact('encargados'));
    }


    public function create()
    {
        return view('encargado.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            // Usuario
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'telefono' => ['required', 'unique:users'],
            'password' => ['required', 'string'],

            // Encargado
            'area' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'max:255'],
        ]);

        try {

            DB::transaction(function () use ($request) {

                // Crear usuario
                $user = User::create([
                    'nombre' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'email' => $request->email,
                    'telefono' => $request->telefono,
                    'password' => bcrypt($request->password),
                ]);

                // Asignar rol
                $user->assignRole('encargado');

                // Crear encargado
                Encargado::create([
                    'user_id' => $user->id,
                    'area' => $request->area,
                    'cargo' => $request->cargo,
                ]);
            });

            return redirect()
                ->route('encargados.index')
                ->with('success', 'Encargado registrado correctamente.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function show(Encargado $encargado)
    {
        $encargado->load('user');

        return view('encargado.show', compact('encargado'));
    }


    public function edit(Encargado $encargado)
    {
        $encargado->load('user');

        return view('encargado.edit', compact('encargado'));
    }


    public function update(Request $request, Encargado $encargado)
    {

        $encargado->load('user');

        $request->validate([
            // Usuario
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $encargado->user->id],
            'telefono' => ['required', 'unique:users,telefono,' . $encargado->user->id],
            'password' => ['nullable', 'string'],

            // Encargado
            'area' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'max:255'],
        ]);

        try {

            DB::transaction(function () use ($request, $encargado) {

                $userData = [
                    'nombre' => $request->nombre,
                    'apellido_paterno' => $request->apellido_paterno,
                    'apellido_materno' => $request->apellido_materno,
                    'email' => $request->email,
                    'telefono' => $request->telefono,
                ];

                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($request->password);
                }

                // Actualizar usuario
                $encargado->user->update($userData);

                // Actualizar encargado
                $encargado->update([
                    'area' => $request->area,
                    'cargo' => $request->cargo,
                ]);
            });

            return redirect()
                ->route('encargados.index')
                ->with('success', 'Encargado actualizado correctamente.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function destroy(Encargado $encargado)
    {

        try {

            DB::transaction(function () use ($encargado) {

                $encargado->update([
                    'estatus' => false,
                ]);

                if ($encargado->user) {
                    $encargado->user->update([
                        'estatus' => false,
                    ]);
                }
            });

            return redirect()
                ->route('encargados.index')
                ->with('success', 'Encargado eliminado correctamente.');

        } catch (\Throwable $e) {

            return redirect()
                ->route('encargados.index')
                ->with('error', 'Ocurrió un error: ' . $e->getMessage());
        }
    }
}
