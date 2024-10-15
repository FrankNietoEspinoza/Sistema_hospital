<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Horario;

class HorarioController extends Controller
{
    public function crear(Doctor $doctor)
    {
        return view('horarios.crear', compact('doctor'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'fecha' => 'required|date', // Validación de la fecha
            'hora_inicio' => 'required|date_format:H:i:s',
            'hora_fin' => 'required|date_format:H:i:s|after:hora_inicio',
            'turno' => 'required|string', // Validar el campo turno
        ]);

        Horario::create([
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha, // Guardar la fecha
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'turno' => $request->turno, // Guardar el turno
        ]);

        return redirect()->route('doctores.index')->with('success', 'Horario agregado correctamente.');
    }



    public function actualizar(Request $request, Horario $horario)
    {
        $request->validate([
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
            'fecha' => 'required|date', // Validar la fecha
        ]);

        $horario->update([
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
            'fecha' => $request->fecha, // Actualizar la fecha
        ]);

        return redirect()->route('doctores.index', $horario->doctor_id)->with('success', 'Horario actualizado correctamente.');
    }



    public function eliminarTodos(Doctor $doctor)
    {
        // Eliminar todos los horarios del doctor
        $doctor->horarios()->delete();

        // Redirigir de vuelta a la página de doctores con un mensaje de éxito
        return redirect()->route('doctores.index')->with('success', 'Todos los horarios del doctor han sido eliminados correctamente.');
    }
}
