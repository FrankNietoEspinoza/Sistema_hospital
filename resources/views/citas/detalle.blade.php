@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles de la Cita</h2>
    <div>
        <p><strong>Paciente:</strong> {{ $cita->paciente->nombre }}</p>
        <p><strong>Servicio:</strong> {{ $cita->servicio->Nombre_servicio }}</p>
        <p><strong>Recepcionista:</strong> {{ $cita->recepcionista->name }}</p>
        <p><strong>Fecha y Hora:</strong> {{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d-m-Y h:i A') }}</p>
        <p><strong>Estado:</strong> {{ $cita->estado }}</p>
    </div>
    <a href="{{ route('citas.mostrar') }}" class="btn btn-secondary">Volver a la lista</a>
</div>
@endsection
