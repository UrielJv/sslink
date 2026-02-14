<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpia de cache de los permisos
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Definicion de los nombres de los modulos para los permisos
        $modulos = [
            // administrador
            'usuario',

            // Encargado
            'asistencia',

            // Estudiante
            'perfil',
            'bitacora',
        ];

        // Acciones que se podran realizar por cada modulo
        $acciones = ['ver', 'crear', 'editar', 'eliminar'];

        // Creacion de permisos para los modulos
        $permisos = [];
        foreach ($modulos as $modulo) {
            foreach ($acciones as $accion) {
                $permisos[] = "{$modulo}.{$accion}";
                Permission::firstOrCreate([
                    'name' => "{$modulo}.{$accion}",
                    'guard_name' => 'web',
                ]);
            }
        }

        // Creacion de roles
        $admin      = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $encargado  = Role::firstOrCreate(['name' => 'encargado', 'guard_name' => 'web']);
        $estudiante  = Role::firstOrCreate(['name' => 'estudiante', 'guard_name' => 'web']);

        // Asignacion de permisos a cada rol del sistema

        // Administrador - todos los permisos
        $admin->syncPermissions($permisos);

        // Encargado - Solo acciones que hara encargado (pendiente)
        $encargado->syncPermissions([
            'asistencia.crear',
            'asistencia.editar',
            'asistencia.ver',
            'asistencia.eliminar',
            'bitacora.ver',
            'bitacora.crear',
            'bitacora.editar',
            'bitacora.eliminar',
        ]);

        // Estudiante - Solo acciones que hara estudiante
        $estudiante->syncPermissions([
            'bitacora.ver',
            'perfil.ver',
        ]);

        // Asignacion del rol administrador a la cuenta de admin@sslink.com
        $userAdmin = User::where('email', 'admin@sslink.com')->first();
        if ($userAdmin) {
            $userAdmin->syncRoles(['admin']);
        }
    }
}
