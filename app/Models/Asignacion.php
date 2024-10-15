<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'servicio_id',
        'dia',
        'turno',
    ];

     // Indicar el nombre correcto de la tabla
     protected $table = 'asignaciones';
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
