@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/doctor.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<div class="doctor-container">
    <h1 class="text-center">Lista de Doctores</h1>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#crearDoctorModal">
        <i class="fas fa-plus"></i> Crear
    </button>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">N°</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Apellidos</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Servicio</th>
                <th class="text-center">Horarios</th> 
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach($doctores as $doctor)
            <tr>
                <td class="text-center">{{ $contador++ }}</td>
                <td>{{ $doctor->nombre }}</td>
                <td>{{ $doctor->apellidos }}</td>
                <td>{{ $doctor->telefono }}</td>
                <td class="text-center">{{ $doctor->servicio->Nombre_servicio }}</td>

                <!-- Mostrar los horarios del doctor -->
                <td>
                    @if($doctor->horarios->isEmpty())
                        <span class="text-muted">Sin horarios asignados</span>
                    @else
                        <ul>
                            @foreach($doctor->horarios as $horario)
                                <li>
                                    {{ $horario->fecha }} - {{ ucfirst($horario->turno) }}: {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                </li>
                            @endforeach
                        </ul>

                        <!--/*/*/*///*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*  -->
                        <!-- Botón para eliminar todos los horarios -->
                        <form action="{{ route('horarios.eliminarTodos', $doctor->id) }}" method="POST" id="formEliminarTodos{{ $doctor->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" title="Eliminar todos los horarios" onclick="confirmDeleteAll('{{ $doctor->id }}')">
                                <i class="fas fa-trash-alt"></i> Eliminar Todos los Horarios
                            </button>
                        </form>

                    @endif
                </td>

                <td class="text-center">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editarDoctorModal{{ $doctor->id }}" title="Editar Doctor">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('doctores.eliminar', $doctor->id) }}" method="POST" style="display:inline;" id="formEliminar{{ $doctor->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" title="Eliminar Doctor" onclick="confirmDelete('{{ $doctor->id }}')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    
                    <!-- Botón de agregar horario -->
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#addHorarioModal">
                        Agregar Horario
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal de creación de doctor -->
<div class="modal fade" id="crearDoctorModal" tabindex="-1" aria-labelledby="crearDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearDoctorModalLabel">Crear Doctor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('doctores.guardar') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
                        @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}">
                        @error('apellidos')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                        @error('telefono')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_servicio">Servicio:</label>
                        <select name="id_servicio" class="form-control" required>
                            <option value="">Seleccione un servicio</option>
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}" {{ old('id_servicio') == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->Nombre_servicio }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_servicio')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div><br>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--MODAL PARA LA SELECCION DE EDITAR DE LOS DOCTORES -->
@foreach($doctores as $doctor)
<div class="modal fade" id="editarDoctorModal{{ $doctor->id }}" tabindex="-1" aria-labelledby="editarDoctorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarDoctorModalLabel">Editar Doctor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('doctores.actualizar', $doctor->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $doctor->nombre) }}">
                        @error('nombre')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $doctor->apellidos) }}">
                        @error('apellidos')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $doctor->telefono) }}">
                        @error('telefono')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="id_servicio">Servicio:</label>
                        <select name="id_servicio" class="form-control" required>
                            @foreach($servicios as $servicio)
                                <option value="{{ $servicio->id }}" {{ old('id_servicio', $doctor->id_servicio) == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->Nombre_servicio }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_servicio')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div><br>
                    <button type="submit" class="btn btn-success">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Modal para agregar horario -->
<div class="modal fade" id="addHorarioModal" tabindex="-1" role="dialog" aria-labelledby="addHorarioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addHorarioModalLabel">Agregar Horario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
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
                    </div><br>

                    <button type="submit" class="btn btn-success">Guardar Horario</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach


<script>
    function confirmDelete(doctorId) {
        event.preventDefault(); // Evita el envío automático del formulario
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás recuperar este doctor después de eliminarlo.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formEliminar' + doctorId).submit(); // Envía el formulario
            }
        });
    }
</script>

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

<script>
    function confirmDeleteAll(doctorId) {
        event.preventDefault(); // Evita el envío automático del formulario
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Se eliminarán todos los horarios de este doctor. Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar todos los horarios',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('formEliminarTodos' + doctorId).submit(); // Envía el formulario
            }
        });
    }
</script>


@endsection
