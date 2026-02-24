<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Estudiante extends Model
{

    protected $fillable = [
        'user_id',
        'encargado_id',
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'codigo_postal',
        'municipio',
        'sexo',
        'telefono_tutor',
        'matricula',
        'carrera',
        'escuela',
        'cct',
        'horas_requeridas',
        'horas_actuales',
        'area',
        'fecha_inicio',
        'fecha_fin',
        'estatus',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'horas_requeridas' => 'integer',
        'horas_actuales' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function encargado()
    {
        return $this->belongsTo(Encargado::class);
    }

    public function getServicioTerminadoAttribute()
    {
        return $this->horas_actuales >= $this->horas_requeridas;
    }
}



