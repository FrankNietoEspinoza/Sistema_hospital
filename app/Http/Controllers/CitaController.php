<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CitaController extends Controller
{
    public function crear()
    {
        // OBTIENE LOS PACIENTES Y SERVICIOS DE LA BASE DE DATOS
        $pacientes = Paciente::all();
        $servicios = Servicio::all();
        return view('citas.crearCita', compact('pacientes', 'servicios'));
    }

    public function guardar(Request $request)
    {
        // VALIDACION DE LOS DATOS RECIBIDOS DEL FORMULARIO
        $request->validate([
            'fecha' => 'required|date',
            'id_paciente' => 'required|exists:pacientes,id',
            'id_servicio' => 'required|exists:servicios,id',
            'id_doctor' => 'required|exists:doctors,id',
            'hora' => 'required'
        ]);

        // ESTA PARTE OBTIENE AL USUARIO QUE SE LOGUEO
        $user = Auth::user();
        // VERIFICA SI EL USUARIO QUE SE LOGEO TIENE EL PERFIL DE RECEPCIONISTA
        if ($user->perfil !== 'Recepcionista') {
            return redirect()->route('citas.mostrar')->with('error', 'No autorizado');
        }

        // Verifica si ya existe una cita en la misma fecha y hora para el mismo servicio
        // Hace que el mensaje de eliminacion aparezca cuando de verdad hay un conflicto de horario 
        $fechaHora = $request->input('fecha') . ' ' . $request->input('hora') . ':00';
        $existeCita = Cita::where('fecha_hora', $fechaHora)
                          ->where('id_servicio', $request->input('id_servicio'))
                          ->where('id_doctor', $request->input('id_doctor'))
                          ->exists();

        if ($existeCita) {
            return redirect()->route('citas.mostrar')->with('error', 'La hora de la Cita ya existe para este Servicio.');
        }

        // Reducción de cupos disponibles
        $servicio = Servicio::find($request->input('id_servicio'));
        // Verifica si hay cupos disponibles para el servicio
        if ($servicio->Cupos_disponibles > 0) {
            // Creación de una nueva cita
            Cita::create([
                'fecha_hora' => $fechaHora,
                'id_paciente' => $request->input('id_paciente'),
                'id_servicio' => $request->input('id_servicio'),
                'id_doctor' => $request->input('id_doctor'),
                'id_recepcionista' => $user->id,
                'estado' => 'Programado',
            ]);

            // Reducción de cupos disponibles
            $servicio->Cupos_disponibles -= 1;
            $servicio->save();

            return redirect()->route('citas.mostrar')->with('success', 'Cita creada correctamente');
        } else {
            return redirect()->route('citas.mostrar')->with('error', 'No hay cupos disponibles para este servicio.');
        }
    }

    public function mostrar()
    {
        $citas = Cita::with(['paciente', 'servicio', 'recepcionista', 'doctor'])->get();
        $pacientes = Paciente::all();
        $servicios = Servicio::all();
        return view('citas.mostrarCita', compact('citas', 'pacientes', 'servicios'));
    }

    public function eliminar(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.mostrar')->with('success', 'Cita eliminada correctamente');
    }

    public function seleccionarHora(Request $request)
    {
        $turno = $request->query('turno');

        if ($turno === 'mañana') {
            $horas = $this->generarHoras('08:00', '13:00', 15);
        } elseif ($turno === 'tarde') {
            $horas = $this->generarHoras('14:30', '19:00', 15);
        } else {
            $horas = [];
        }

        return view('citas.seleccionarHora', compact('horas', 'turno'));
    }

    private function generarHoras($start, $end, $interval)
    {
        $horas = [];
        $startTime = Carbon::createFromFormat('H:i', $start);
        $endTime = Carbon::createFromFormat('H:i', $end);

        while ($startTime <= $endTime) {
            $horas[] = $startTime->format('H:i');
            $startTime->addMinutes($interval);
        }

        return $horas;
    }

    public function obtenerHorasOcupadas(Request $request)
    {
        $fecha = $request->query('fecha');
        $id_servicio = $request->query('id_servicio');

        //obtener las citas para la fecha y servicio seleccionado
        $citas = Cita::whereDate('fecha_hora', $fecha)
                    ->where('id_servicio', $id_servicio)
                    ->pluck('fecha_hora');

        $horasOcupadas = $citas->map(function($fechaHora)
        {
            return \Carbon\Carbon::parse($fechaHora)->format('H:i');

        });

        return response()->json($horasOcupadas);
    }

    public function detalle(Cita $cita)
    {
        return view('citas.detalle', compact('cita'));
    }

    public function obtenerDoctoresDisponibles(Request $request)
    {
        $fecha = $request->query('fecha');
        $id_servicio = $request->query('id_servicio');

        // Obtener los doctores con el servicio seleccionado
        $doctores = Doctor::where('id_servicio', $id_servicio)
                        ->whereHas('horarios', function ($query) use ($fecha) {
                            $query->where('fecha', $fecha);
                        })->get();

        return response()->json($doctores);
    }

}
