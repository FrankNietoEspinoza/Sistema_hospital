<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PacienteController extends Controller
{
    
    public function crear()
    {
        $pacientes = Paciente::all(); // Obtener todos los pacientes para mostrarlos en la lista 
        return view("pacientes.crearPaciente", compact('pacientes'));
    }

    public function store(Request $request)
    {
        // Validar los datos antes de guardar
        $request->validate([
            'dni' => 'required|unique:pacientes,dni|size:8',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|digits:9',
            'sexo' => 'required|string|max:10',
            'fecha_nacimiento' => 'required|date',
            'nombre_padre' => 'nullable|string|max:255',
            'nombre_madre' => 'nullable|string|max:255',
            'domicilio' => 'nullable|string|max:255',
            'estado_civil' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'grado_instruccion' => 'nullable|string|max:50',
            'procedencia' => 'nullable|string|max:255'
        ]);

        // Crear al paciente usando el método fill
        Paciente::create($request->all());

        return redirect()->route('pacientes.mostrar')->with('success', 'Paciente registrado exitosamente');
    }

    public function mostrar()
    {
        $pacientes = Paciente::all();

        return view("pacientes.mostrarPaciente",compact("pacientes"));
    }

   // mÉTODOS PARA EDITAR, ACTUALIZAR Y ELIMINAR
    Public function editar(Paciente $paciente)
    {
        return view('pacientes.editarPaciente', compact('paciente'));   
    }

    public function actualizar(Request $request, Paciente $paciente)
    {
        // Validar los datos antes de actualizar
        $request->validate([
            'dni' => 'required|unique:pacientes,dni,' . $paciente->id . '|size:8',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'telefono' => 'required|digits:9',
            'sexo' => 'required|string|max:10',
            'fecha_nacimiento' => 'required|date',
            'nombre_padre' => 'nullable|string|max:255',
            'nombre_madre' => 'nullable|string|max:255',
            'domicilio' => 'nullable|string|max:255',
            'estado_civil' => 'nullable|string|max:50',
            'religion' => 'nullable|string|max:50',
            'grado_instruccion' => 'nullable|string|max:50',
            'procedencia' => 'nullable|string|max:255'
        ]);

        // Actualizar al paciente usando el método fill
        $paciente->fill($request->all());
        $paciente->save();

        return redirect()->route('pacientes.mostrar')->with('success', 'Paciente actualizado exitosamente');
    }

    //ESTA PARTE ES PARA QUE ELIMINE UN PACIENTE
    Public function eliminar(Paciente $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.mostrar')->with('success', 'Paciente eliminado exitosamente');
    }
}