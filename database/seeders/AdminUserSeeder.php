<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'admin@sslink.com',
            ],
            [
                'nombre' => 'Administrador',
                'apellido_paterno' => 'Sistema',
                'apellido_materno' => 'SSLink',
                'telefono' => null,
                'password' => Hash::make('admin123'),
                'estatus' => true,
            ]
        );
    }
}
