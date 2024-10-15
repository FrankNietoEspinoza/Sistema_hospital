<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicioController extends Controller
{
    public function crear()
    {
        return view("servicios.crearServicio");
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre_servicio' => 'required|max:255',
            'cupos_disponibles' => 'required|numeric|lte:20',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        //CREACION DEL SERVICIO
        $servicio = new Servicio;
        $servicio->Nombre_servicio = $request->input('nombre_servicio');
        $servicio->Cupos_disponibles = $request->input('cupos_disponibles');
        //SUBIDA DE LA IMAGEN 
        if ($request->hasFile('imagen')) {
            $fileName = time() . '.' . $request->imagen->extension();
            $path = $request->imagen->storeAs('images', $fileName, 'public');
            $servicio->imagen = $fileName; //$path
        }

        $servicio->save();

        return redirect()->route('servicios.mostrar');
    }

    public function mostrar()
    {
        $servicios = Servicio::all();
        return view('servicios.mostrarServicio', compact('servicios'));
    }

    Public function actualizar(Request $request, Servicio $servicio){

        // Validación de los campos
        $request->validate([
            'cupos_disponibles' => 'required|numeric|min:0|max:16',
            'cupos_extra' => 'nullable|numeric|min:0|max:4'
        ]);

        //asignacion de cupos:
        $cuposDisponibles = $request->input('cupos_disponibles');
        $cuposExtra = $request->input('cupos_extra');

        //verificacion si es que se solicitaron cupos extra
        if($cuposExtra <= 4){
            $servicio->Cupos_disponibles = $cuposDisponibles + $cuposExtra;
        }else{
            $servicio->Cupos_disponibles = $cuposDisponibles;
        }
        
        $servicio->save();

        return redirect()->route('servicios.mostrar')->with('success', 'cupos disponibles actualizado');
    }

    public function eliminar(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.mostrar')->with('success', 'Servicio eliminado exitosamente');
    }
}

