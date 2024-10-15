<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nombre_servicio', 
        'Cupos_disponibles', 
        'imagen',
        'cupos_extra',
    ];
}
