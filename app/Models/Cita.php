<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_hora',
        'id_paciente',
        'id_servicio',
        'id_doctor',
        'id_recepcionista',
        'estado'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    public function recepcionista()
    {
        return $this->belongsTo(User::class, 'id_recepcionista');
    }

    
    public function getFechaAttribute()
    {
        return Carbon::parse($this->fecha_hora)->format('d/m/Y');
    }


    // En el modelo de Cita
    public function getTurnoAttribute()
    {
        $hora = \Carbon\Carbon::parse($this->fecha_hora)->format('H:i');
        if ($hora >= '07:00' && $hora <= '13:00') {
            return 'Mañana';
        } elseif ($hora >= '13:15' && $hora <= '19:00') {
            return 'Tarde';
        } else {
            return 'Indefinido';
        }
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'id_doctor');
    }


    
}
