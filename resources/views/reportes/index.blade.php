<!-- resources/views/reportes/index.blade.php -->
@extends('layouts.app')

@section('content')
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/reportes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mostrarCita.css') }}">
</head>
<body>
    <div class="reportes-container">
        <h2><i class="bi bi-file-earmark-text"  ></i> Reporte de Citas</h2>

        <form action="{{ route('reportes.buscar') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_servicio"><i class="fas fa-hospital-alt icon"></i> Seleccionar Servicio:</label>
                <select name="id_servicio" class="form-control" required>
                    <option value="">Seleccione un servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->Nombre_servicio }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
        </form>


        @if(isset($citas))
            @if ($servicioSeleccionado)
                <h3>Citas para el servicio de {{ $servicioSeleccionado->Nombre_servicio }}</h3>
            @endif

            @if($citas->isEmpty())
                @if ($servicioSeleccionado)
                    <p>No se encontraron citas para el servicio de  {{ $servicioSeleccionado->Nombre_servicio }}</p>
                @endif
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">N°</th>
                            <th class="text-center">Fecha y Hora</th>
                            <th class="text-center">Paciente</th>
                            <th class="text-center">Servicio</th>
                            <th class="text-center">Recepcionista</th>
                            <!--<th>Estado</th>-->
                            <th class="text-center">Turno</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $contador = 1; @endphp
                        @foreach($citas as $cita)
                            <tr>
                                <td class="text-center">{{ $contador++ }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d-m-Y H:i') }}</td>
                                <td class="text-center">{{ $cita->paciente->nombre }}</td>
                                <td class="text-center">{{ $cita->servicio->Nombre_servicio }}</td>
                                <td class="text-center">{{ $cita->recepcionista->name }}</td>
                                <!--<td>{{ $cita->estado }}</td>-->
                                <td class="text-center"> 
                                <!-- En esta parte se asignan las horas laborales --> 
                                    @php
                                        $hora = \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i');
                                        if($hora >= '08:00' && $hora <= '13:00') {
                                            echo '<span style="color: green;">Mañana</span>';
                                        } elseif($hora >= '14:30' && $hora <= '19:00') {
                                            echo '<span style="color: red;">Tarde</span>';
                                        }
                                    @endphp
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endif
    </div>
</body>
@endsection
