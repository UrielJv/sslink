<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable = [
        'encargado_id',
        'estudiante_id',
        'fecha',
        'estado',
        'horas_cumplidas',
        'observaciones',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function encargado()
    {
        return $this->belongsTo(Encargado::class, 'encargado_id');
    }

    public function actividades()
    {
        return $this->hasMany(Actividades::class);
    }
}
