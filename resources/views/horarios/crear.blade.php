@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $doctor->nombre }} {{ $doctor->apellidos }}</h1>

    <form action="{{ route('horarios.guardar') }}" method="POST">
        @csrf
        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">

        <!-- Campo de fecha -->
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
            @error('fecha')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <!-- Campo de turno -->
        <div class="form-group">
            <label for="turno">Turno</label>
            <select name="turno" id="turno" class="form-control" required>
                <option value="">Seleccione un turno</option>
                <option value="mañana">Mañana (7:00 AM - 1:00 PM)</option>
                <option value="tarde">Tarde (1:00 PM - 7:00 PM)</option>
            </select>
            @error('turno')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campos de horario que se mostrarán automáticamente -->
        <div id="horario" class="d-none">
            <div class="form-group">
                <label for="hora_inicio">Hora de Inicio</label>
                <input type="text" id="hora_inicio" name="hora_inicio" class="form-control" readonly>
            </div>

            <div class="form-group">
                <label for="hora_fin">Hora de Fin</label>
                <input type="text" id="hora_fin" name="hora_fin" class="form-control" readonly>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Guardar Horario</button>
    </form>
</div>

<script>
    document.getElementById('turno').addEventListener('change', function() {
        const turno = this.value;
        const horarioDiv = document.getElementById('horario');
        const horaInicioInput = document.getElementById('hora_inicio');
        const horaFinInput = document.getElementById('hora_fin');

        if (turno === 'mañana') {
            horarioDiv.classList.remove('d-none');
            horaInicioInput.value = '07:00:00'; // Formato 24 horas
            horaFinInput.value = '13:00:00'; // 1:00 PM es 13:00 en formato 24 horas
        } else if (turno === 'tarde') {
            horarioDiv.classList.remove('d-none');
            horaInicioInput.value = '13:00:00'; // 1:00 PM en formato 24 horas
            horaFinInput.value = '19:00:00'; // 7:00 PM es 19:00 en formato 24 horas
        } else {
            horarioDiv.classList.add('d-none');
            horaInicioInput.value = '';
            horaFinInput.value = '';
        }
    });
</script>
@endsection
