<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'id_servicio',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio');
    }

    public function citas()
    {
        return $this->hasMany(Cita::class, 'id_doctor');
    }

    // Doctor.php
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'doctor_id');
    }

    


}
