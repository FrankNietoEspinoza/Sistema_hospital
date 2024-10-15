<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignacion;
use App\Models\Doctor;
use App\Models\Servicio;

class AsignacionController extends Controller
{
    public function index()
    {
        $asignaciones = Asignacion::with(['doctor', 'servicio'])->get();
        return view('asignaciones.index', compact('asignaciones'));
    }

    public function crear()
    {
        $doctores = Doctor::with('servicio')->get();
        return view('asignaciones.crear', compact('doctores'));
    }


    public function guardar(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'servicio_id' => 'required|exists:servicios,id',
            'dia' => 'required|string',
            'turno' => 'required|in:mañana,tarde',
        ]);

        Asignacion::create($request->all());
        return redirect()->route('asignaciones.index')->with('success', 'Asignación creada correctamente.');
    }

    public function eliminar(Asignacion $asignacion)
    {
        $asignacion->delete();
        return redirect()->route('asignaciones.index')->with('success', 'Asignación eliminada correctamente.');
    }
}
