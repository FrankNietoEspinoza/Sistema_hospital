@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/crearCita.css')}}">
</head>
<body>
    <div class="crear-container">
        <h2>Crear Nueva Cita</h2>
        <form action="{{ route('citas.guardar') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="fecha"><i class="fas fa-calendar-day icon"></i> Fecha:</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="id_paciente"><i class="fas fa-user icon"></i> Paciente:</label>
                <select name="id_paciente" class="form-control" required>
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_servicio"><i class='fas fa-user-md'></i> Servicio:</label>
                <select name="id_servicio" class="form-control" required>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->Nombre_servicio }} ({{ $servicio->Cupos_disponibles }} cupos disponibles)</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="turno"><i class="fas fa-clock icon"></i> Turno:</label>
                <select name="turno" id="turno" class="form-control" required>
                    <option value="">Seleccione un turno</option>
                    <option value="mañana">Mañana</option>
                    <option value="tarde">Tarde</option>
                </select>
            </div>
            <div class="form-group">
                <label for="hora"><i class="fas fa-clock icon"></i> Hora:</label>
                <select name="hora" id="hora" class="form-control" required>
                    <option value="">Seleccione un turno primero</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save icon"></i> Crear Cita</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const turnoSelect = document.getElementById('turno');
            const horaSelect = document.getElementById('hora');

            turnoSelect.addEventListener('change', function() {
                const turno = this.value;
                horaSelect.innerHTML = ''; // Limpiar las opciones anteriores

                if (turno === 'mañana') {
                    addOptions(horaSelect, '08:00', '13:00', 15);
                } else if (turno === 'tarde') {
                    addOptions(horaSelect, '14:30', '19:00', 15);
                }
            });

            function addOptions(select, start, end, interval) {
                let startTime = moment(start, 'HH:mm');
                const endTime = moment(end, 'HH:mm');

                while (startTime <= endTime) {
                    const option = document.createElement('option');
                    option.value = startTime.format('HH:mm');
                    option.text = startTime.format('hh:mm A');
                    select.appendChild(option);
                    startTime.add(interval, 'minutes');
                }
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</body>
@endsection
