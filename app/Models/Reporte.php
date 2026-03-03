<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = [
    'asunto',
    'descripcion',
    'gravedad',
    'fecha',
    'emisor_id',
    'receptor_id',
];

    // Relaciones
    public function emisor()
    {
        return $this->belongsTo(User::class, 'emisor_id');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_id');
    }
}