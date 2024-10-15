@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center">Horario</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('asignaciones.crear') }}" class="btn btn-primary mb-3"><i class="fas fa-plus"></i> Crear Asignación</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Doctor</th>
                <th class="text-center">Servicio</th>
                <th class="text-center">Día</th>
                <th class="text-center">Turno</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach($asignaciones as $asignacion)
            <tr>
                <td class="text-center">{{ $contador++ }}</td>
                <td>{{ $asignacion->doctor->nombre }} {{ $asignacion->doctor->apellidos }}</td>
                <td class="text-center">{{ $asignacion->servicio->Nombre_servicio }}</td>
                <td class="text-center">{{ $asignacion->dia }}</td>
                <td class="text-center">{{ ucfirst($asignacion->turno) }}</td>
                <td class="text-center">
                    <form action="{{ route('asignaciones.eliminar', $asignacion->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
