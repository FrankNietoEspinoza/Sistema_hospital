<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Servicio;

class DoctorController extends Controller
{
    public function index()
    {
        $doctores = Doctor::with('servicio', 'horarios')->get();
        $servicios = Servicio::all();
        return view('doctores.index', compact('doctores', 'servicios'));
    }

    public function crear()
    {
        $servicios = Servicio::all();
        return view('doctores.crear', compact('servicios'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:9',
            'id_servicio' => 'required|exists:servicios,id',
        ]);

        Doctor::create($request->all());
        return redirect()->route('doctores.index')->with('success', 'Doctor creado correctamente.');
    }

    public function editar(Doctor $doctor)
    {
        $servicios = Servicio::all();
        return view('doctores.editar', compact('doctor', 'servicios'));
    }

    public function actualizar(Request $request, Doctor $doctor)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:9',
            'id_servicio' => 'required|exists:servicios,id',
        ]);

        $doctor->update($request->all());
        return redirect()->route('doctores.index')->with('success', 'Doctor actualizado correctamente.');
    }

    public function eliminar(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado correctamente.');
    }
}
