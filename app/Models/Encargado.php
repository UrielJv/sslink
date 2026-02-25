<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Encargado extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'area',
        'cargo',
        'estatus',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
}
