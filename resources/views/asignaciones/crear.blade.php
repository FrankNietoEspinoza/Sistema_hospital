@extends('layouts.app')

@section('content')
    <h1>Crear Asignación</h1>

    <form action="{{ route('asignaciones.guardar') }}" method="POST">
        @csrf
        <div>
            <label for="doctor_id">Doctor:</label>
            <select name="doctor_id" id="doctor_id" onchange="actualizarServicio()">
                <option value="">Seleccione un doctor</option>
                @foreach($doctores as $doctor)
                    <option value="{{ $doctor->id }}" data-servicio="{{ $doctor->servicio->Nombre_servicio }}">{{ $doctor->nombre }} {{ $doctor->apellidos }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="servicio">Servicio:</label>
            <input type="text" name="servicio" id="servicio" readonly>
        </div>

        <div>
            <label for="dia">Día:</label>
            <select name="dia_semana" id="dia_semana">
                <option value="Lunes">Lunes</option>
                <option value="Martes">Martes</option>
                <option value="Miércoles">Miércoles</option>
                <option value="Jueves">Jueves</option>
                <option value="Viernes">Viernes</option>
                <option value="Sábado">Sábado</option>
                <option value="Domingo">Domingo</option>
            </select>
        </div>

        <div>
            <label for="turno">Turno:</label>
            <select name="turno" id="turno">
                <option value="mañana">Mañana</option>
                <option value="tarde">Tarde</option>
            </select>
        </div>

        <button type="submit">Guardar Asignación</button>
    </form>

    <script>
        function actualizarServicio() {
            var doctorSelect = document.getElementById('doctor_id');
            var selectedDoctor = doctorSelect.options[doctorSelect.selectedIndex];
            var servicio = selectedDoctor.getAttribute('data-servicio');
            document.getElementById('servicio').value = servicio || '';
        }
    </script>
@endsection
