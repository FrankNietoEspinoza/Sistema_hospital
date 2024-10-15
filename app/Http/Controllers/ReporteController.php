<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Servicio;


class ReporteController extends Controller
{
    public function  index(){
        $servicios = Servicio::all();
        return view('reportes.index', compact('servicios'));
    }

    public function buscar(Request $request){
        $request->validate([
            'id_servicio' => 'required|exists:servicios,id',
        ]); 
        //nombre del servicio seleccionado 
        $servicioSeleccionado = Servicio::find($request->input('id_servicio')); 

         // Obtén las citas del servicio seleccionado
        $citas = Cita::where('id_servicio', $request->input('id_servicio'))->get();
        $servicios = Servicio::all(); // Vuelve a obtener los servicios para el formulario

        return view('reportes.index', compact('citas', 'servicios', 'servicioSeleccionado'));
    }
}
