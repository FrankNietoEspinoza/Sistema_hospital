<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'dni','nombre', 'apellido',
        'telefono', 'sexo', 'fecha_nacimiento',
        'nombre_padre', 'nombre_madre', 'domicilio',
        'estado_civil', 'religion', 'grado_instruccion',
        'procedencia',
    ];
}
