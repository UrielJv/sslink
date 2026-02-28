<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    protected $fillable = [
        'asistencia_id',
        'nombre',
        'descripcion',
        'horas',
    ];

    public function asistencia()
    {
        return $this->belongsTo(Asistencia::class);
    }

}
