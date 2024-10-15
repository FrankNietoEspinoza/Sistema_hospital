@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Pacientemostrar.css')}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="mostrar-container">
        <h1><i class="fas fa-users"></i> Lista de Pacientes</h1>
        <!-- Botón para crear paciente desde la vista mostrar -->
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#crearPacienteModal">
        <i class="fas fa-plus"></i> Registrar 
        </button>
        <!-- final del boton-->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th> N°</th>
                    <th> Nombre</th>
                    <th> Apellido</th>
                    <th> Dni</th>
                    <th> Teléfono</th>
                    <th> Sexo</th>
                    <th> Fecha de Nacimiento</th>
                    <th> Nombre del Padre</th>
                    <th> Nombre de la Madre</th>
                    <th class="text-center"> Domicilio</th>
                    <th> Estado Civil</th>
                    <th> Religión</th>
                    <th> Grado de Instrucción</th>
                    <th> Procedencia</th>
                    
                    <th><i class="fas fa-cogs text-center"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php  $contador = 1; @endphp
                @foreach($pacientes as $paciente)
                    <tr>
                        <td>{{ $contador++}}</td>
                        <td>{{ $paciente->nombre }}</td>
                        <td>{{ $paciente->apellido }}</td>
                        <td>{{ $paciente->dni }}</td>
                        <td>{{ $paciente->telefono }}</td>
                        <td>{{ $paciente->sexo }}</td>
                        <td>{{ $paciente->fecha_nacimiento }}</td>
                        <td>{{ $paciente->nombre_padre }}</td>
                        <td>{{ $paciente->nombre_madre }}</td>
                        <td>{{ $paciente->domicilio }}</td>
                        <td>{{ $paciente->estado_civil }}</td>
                        <td>{{ $paciente->religion }}</td>
                        <td>{{ $paciente->grado_instruccion }}</td>
                        <td>{{ $paciente->procedencia }}</td>
                        <td>
                            <button class="btn btn-success" data-toggle="modal" data-target="#editarPacienteModal{{ $paciente->id }}">
                            <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('pacientes.eliminar', $paciente->id) }}" method="POST" class="delete-form" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-btn"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    <!--Modal editar-->
                    <div class="modal fade" id="editarPacienteModal{{ $paciente->id }}" tabindex="-1" role="dialog" aria-labelledby="editarPacienteModalLabel{{ $paciente->id }}" aria-hidden="true">
                        <div class="modal-dialog edit-modal-dialog" role="document">
                            <div class="modal-content edit-modal-content">
                                <div class="modal-header edit-modal-header">
                                    <h5 class="modal-title edit-modal-title" id="editarPacienteModalLabel{{ $paciente->id }}">
                                        <i class="fas fa-edit"></i> Editar Paciente
                                    </h5>
                                    <button type="button" class="close edit-close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body edit-modal-body">
                                    <form action="{{ route('pacientes.actualizar', $paciente->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <!-- Fila 1 -->
                                        <div class="form-row edit-form-row">
                                            <div class="form-group edit-form-group col-md-4">
                                                <label for="dniEdit{{ $paciente->id }}">DNI:</label>
                                                <input type="text" class="form-control edit-form-control" id="dniEdit{{ $paciente->id }}" name="dni" value="{{ $paciente->dni }}" required>
                                            </div>
                                            <div class="form-group edit-form-group col-md-4">
                                                <label for="nombreEdit{{ $paciente->id }}">Nombre:</label>
                                                <input type="text" class="form-control edit-form-control" id="nombreEdit{{ $paciente->id }}" name="nombre" value="{{ $paciente->nombre }}" required>
                                            </div>
                                            <div class="form-group edit-form-group col-md-4">
                                                <label for="apellidoEdit{{ $paciente->id }}">Apellido:</label>
                                                <input type="text" class="form-control edit-form-control" id="apellidoEdit{{ $paciente->id }}" name="apellido" value="{{ $paciente->apellido }}" required>
                                            </div>
                                        </div>
                                        <!-- Fila 2 -->
                                        <div class="form-row edit-form-row">
                                            <div class="form-group edit-form-group col-md-3">
                                                <label for="telefonoEdit{{ $paciente->id }}">Teléfono:</label>
                                                <input type="text" class="form-control edit-form-control" id="telefonoEdit{{ $paciente->id }}" name="telefono" value="{{ $paciente->telefono }}" required>
                                            </div>
                                            <div class="form-group edit-form-group col-md-3">
                                                <label for="sexoEdit{{ $paciente->id }}">Sexo:</label>
                                                <select class="form-control edit-form-control" id="sexoEdit{{ $paciente->id }}" name="sexo" required>
                                                    <option value="Masculino" {{ $paciente->sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="Femenino" {{ $paciente->sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                                </select>
                                            </div>
                                            <div class="form-group edit-form-group col-md-5">
                                                <label for="fechaNacimientoEdit{{ $paciente->id }}">Fecha de Nacimiento:</label>
                                                <input type="date" class="form-control edit-form-control" id="fechaNacimientoEdit{{ $paciente->id }}" name="fecha_nacimiento" value="{{ $paciente->fecha_nacimiento }}" required>
                                            </div>
                                        </div>
                                        <!-- Fila 3 -->
                                        <div class="form-row edit-form-row">
                                            <div class="form-group edit-form-group col-md-4">
                                                <label for="nombrePadreEdit{{ $paciente->id }}">Nombre del Padre:</label>
                                                <input type="text" class="form-control edit-form-control" id="nombrePadreEdit{{ $paciente->id }}" name="nombre_padre" value="{{ $paciente->nombre_padre }}">
                                            </div>
                                            <div class="form-group edit-form-group col-md-4">
                                                <label for="nombreMadreEdit{{ $paciente->id }}">Nombre de la Madre:</label>
                                                <input type="text" class="form-control edit-form-control" id="nombreMadreEdit{{ $paciente->id }}" name="nombre_madre" value="{{ $paciente->nombre_madre }}">
                                            </div>
                                            <div class="form-group edit-form-group col-md-4">
                                                <label for="domicilioEdit{{ $paciente->id }}">Domicilio:</label>
                                                <input type="text" class="form-control edit-form-control" id="domicilioEdit{{ $paciente->id }}" name="domicilio" value="{{ $paciente->domicilio }}" required>
                                            </div>
                                        </div>
                                        <!-- Fila 4 -->
                                        <div class="form-row edit-form-row">
                                            <div class="form-group edit-form-group col-md-4">
                                                <label for="estadoCivilEdit{{ $paciente->id }}">Estado Civil:</label>
                                                <select class="form-control edit-form-control" id="estadoCivilEdit{{ $paciente->id }}" name="estado_civil" required>
                                                    <option value="Soltero" {{ $paciente->estado_civil == 'Soltero' ? 'selected' : '' }}>Soltero</option>
                                                    <option value="Casado" {{ $paciente->estado_civil == 'Casado' ? 'selected' : '' }}>Casado</option>
                                                    <option value="Viudo" {{ $paciente->estado_civil == 'Viudo' ? 'selected' : '' }}>Viudo</option>
                                                    <option value="Divorciado" {{ $paciente->estado_civil == 'Divorciado' ? 'selected' : '' }}>Divorciado</option>
                                                </select>
                                            </div>
                                            <div class="form-group edit-form-group col-md-3">
                                                <label for="religionEdit{{ $paciente->id }}">Religión:</label>
                                                <input type="text" class="form-control edit-form-control" id="religionEdit{{ $paciente->id }}" name="religion" value="{{ $paciente->religion }}">
                                            </div>
                                            <div class="form-group edit-form-group col-md-5">
                                                <label for="gradoInstruccionEdit{{ $paciente->id }}">Grado de Instrucción:</label>
                                                <select class="form-control edit-form-control" id="gradoInstruccionEdit{{ $paciente->id }}" name="grado_instruccion" required>
                                                    <option value="Primaria" {{ $paciente->grado_instruccion == 'Primaria' ? 'selected' : '' }}>Primaria</option>
                                                    <option value="Secundaria" {{ $paciente->grado_instruccion == 'Secundaria' ? 'selected' : '' }}>Secundaria</option>
                                                    <option value="No Consigna" {{ $paciente->grado_instruccion == 'No Consigna' ? 'selected' : '' }}>No Consigna</option>
                                                    <option value="Universitario" {{ $paciente->grado_instruccion == 'Universitario' ? 'selected' : '' }}>Universitario</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- Fila 5 -->
                                        <div class="form-row edit-form-row">
                                            <label for="procedenciaEdit{{ $paciente->id }}">Procedencia:</label>
                                            <input type="text" class="form-control edit-form-control" id="procedenciaEdit{{ $paciente->id }}" name="procedencia" value="{{ $paciente->procedencia }}">
                                        </div>
                                        <div class="modal-footer edit-modal-footer">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-sync"></i> Actualizar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para crear -->
    <div class="modal fade" id="crearPacienteModal" tabindex="-1" role="dialog" aria-labelledby="crearPacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearPacienteModalLabel">
                        <i class="fas fa-plus-circle"></i> Crear Paciente
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="crearPacienteForm" action="{{ route('pacientes.store') }}" method="POST">
                        @csrf
                        <!-- Fila 1-->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="dni">DNI:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="dni" name="dni" required placeholder="Ingrese DNI">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" id="buscarDniBtn">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ingrese nombre">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required placeholder="Ingrese apellido">
                            </div>
                        </div>
                        <!-- Fila 2-->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required placeholder="Ingrese teléfono">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sexo">Sexo:</label>
                                <select class="form-control" id="sexo" name="sexo" required>
                                    <option value="">Seleccione el sexo</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                </select>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="fechaNacimiento" name="fecha_nacimiento" required>
                            </div>
                        </div>
                        <!-- Fila 3-->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="nombre_padre">Nombre del Padre:</label>
                                <input type="text" class="form-control" id="nombrePadre" name="nombre_padre" placeholder="Ingrese..." required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="nombre_madre">Nombre de la Madre:</label>
                                <input type="text" class="form-control" id="nombreMadre" name="nombre_madre" placeholder="Ingrese..." required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="domicilio">Domicilio:</label>
                                <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="Ingrese domicilio" required>
                            </div>
                        </div>
                        <!-- Fila 4-->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="estado_civil">Estado Civil:</label>
                                <select class="form-control" id="estadoCivil" name="estado_civil" required>
                                    <option value="">Seleccione estado civil</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Viudo">Viudo</option>
                                    <option value="Divorciado">Divorciado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="religion">Religión:</label>
                                <input type="text" class="form-control" id="religion" name="religion" placeholder="Ingrese religión" required>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="grado_instruccion">Grado de Instrucción:</label>
                                <select class="form-control" id="gradoInstruccion" name="grado_instruccion" required>
                                    <option value="">Seleccione el grado</option>
                                    <option value="Primaria">Primaria</option>
                                    <option value="Secundaria">Secundaria</option>
                                    <option value="No Consigna">No Consigna</option>
                                    <option value="Universitario">Universitario</option>
                                </select>
                            </div>
                        </div>
                        <!-- Fila 5-->
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="procedencia">Procedencia:</label>
                                <input type="text" class="form-control" id="procedencia" name="procedencia" placeholder="Ingrese procedencia">
                            </div>
                        </div>
                        <div class="modal-footer modal-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        setTimeout(function(){
            var alert = document.querySelector('.alert');
            if(alert){
                alert.style.transition = 'opacity 0.1s';
                alert.style.opacity = '0';
                setTimeout(function(){
                    alert.style.display = 'none';
                }, 150)
            }
        }, 1500)

        /* mensaje antes de eliminar un servicio con SweetAlert2 */
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Evitar la eliminación inmediata
                    var deleteForm = this.closest('form');
                    Swal.fire({
                        title: '¿Está seguro de eliminar al Paciente?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteForm.submit();
                        }
                    });
                });
            });
        });


        document.getElementById('buscarDniBtn').addEventListener('click', function() {
            const dni =document.getElementById("dni").value;
            if(dni) {
                fetch('/consulta-dni?dni=' + dni)
                    .then(response => response.json())
                    .then(data => {
                        if(data.nombres && data.apellidoPaterno && data.apellidoMaterno) {
                            document.getElementById('nombre').value = data.nombres;
                            document.getElementById('apellido').value = data.apellidoPaterno + ' ' + data.apellidoMaterno;
                        } else {
                            alert('No se encontraron datos para el DNI ingresado');
                        }
                    })
                    .catch(error => console.error('Error al consultar el DNI:', error));
            } else {
                alert('Por favor, ingrese un número de DNI');
            }
        });

    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
