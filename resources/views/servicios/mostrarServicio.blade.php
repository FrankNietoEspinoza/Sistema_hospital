@extends('layouts.app')

@section('content')

<head>
    <meta charset="UTF-8">
    <!-- Enlace al archivo CSS personalizado -->
    <link href="{{ asset('css/mostrarServicio.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="mostrar-container">
        <div class="text-center mb-4 text-white">
            <h1><i class='fas fa-user-md'></i> Servicios</h1>
        </div>

        <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#crearServicioModal">
            <i class="fas fa-plus"></i> Crear
        </button>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (count($servicios) > 0)
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="bg-primary text-white text-center">N°</th>
                        <th class="bg-primary text-white text-center"><i class="fas fa-image"></i> Imagen</th>
                        <th class="bg-primary text-white text-center"><i class="fas fa-file-signature"></i> Nombre del Servicio</th>
                        <th class="bg-primary text-white text-center"><i class="fas fa-users"></i> Cupos Disponibles</th>
                        <th class="bg-primary text-white text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $index => $servicio)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">
                                @if ($servicio->imagen)
                                    <img src="{{ asset('storage/images/' . $servicio->imagen) }}" class="img-thumbnail" width="100">
                                @else
                                    <span class="text-muted"><i class="fas fa-image-slash"></i> Sin imagen</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $servicio->Nombre_servicio }}</td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('servicios.actualizar', $servicio) }}" id="form-{{ $servicio->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="cupos_disponibles" value="{{ $servicio->Cupos_disponibles }}" min="0" max="16" required class="form-control d-inline-block" style="width: 70px;">
                                    <label for="cupos_extra">Asigne el N° de Cupos Extra:</label>
                                    <input type="number" name="cupos_extra" value="0" min="0" max="4" class="form-control d-inline-block" style="width: 70px;">
                                </form>
                            </td>
                            <td class="text-center action-cell">
                                <button type="button" class="btn btn-primary btn-sm update-btn" data-servicio-id="{{ $servicio->id }}" onclick="submitForm(this)">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <form action="{{ route('servicios.eliminar', $servicio->id) }}" method="POST" class="delete-form" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center"><i class="fas fa-info-circle"></i> No hay servicios creados.</p>
        @endif
    </div>

    <!-- inicio del Modal crear-->
    <div class="modal fade" id="crearServicioModal" tabindex="-1" role="dialog" aria-labelledby="crearServicioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="crearServicioModalLabel"><i class="fas fa-plus-circle"></i> Crear Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- contenido del modal -->
                <div class="modal-body">
                    <form method="POST" action="{{ route('servicios.guardar') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="imagen" class="form-label"><i class="fas fa-image"></i> Imagen del servicio:</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        </div>

                        <div class="mb-3">
                            <label for="nombre_servicio" class="form-label"><i class="fas fa-file-signature"></i> Nombre del Servicio:</label>
                            <select class="form-control" id="nombre_servicio" name="nombre_servicio" required>
                                <option value="" disabled selected>Seleccionar Servicio</option>
                                <option value="Pediatría">Pediatría</option>
                                <option value="Consultoría Neurología">Consultoría Neurología</option>
                                <option value="Ginecología-ARO">Ginecología-ARO</option>
                                <option value="Ecografía Obstétrica">Ecografía Obstétrica</option>
                                <option value="Cardiología">Cardiología</option>
                                <option value="Cardiología Procedimientos">Cardiología Procedimientos</option>
                                <option value="Medicina Integral">Medicina Integral</option>
                                <option value="Psiquiatría">Psiquiatría</option>
                                <option value="Consultoria de Nutrición">Consultoria de Nutrición</option>
                                <option value="Rayos X">Rayos X</option>
                                <option value="Ecografía Partes Blandas">Ecografía Partes Blandas</option>
                                <option value="Ecografía General">Ecografía General</option>
                                <option value="Psicología">Psicología</option>
                                <option value="Odontología">Odontología</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="cupos_disponibles" class="form-label"><i class="fas fa-users"></i> Cupos Disponibles:</label>
                            <input type="number" class="form-control" id="cupos_disponibles" name="cupos_disponibles" min="0" max="16" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> CREAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function submitForm(button) {
            var servicioId = button.getAttribute('data-servicio-id');
            Swal.fire({
                title: '¿Está seguro de actualizar el servicio?',
                text: "Este cambio será permanente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#008000',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Actualizar',
                cancelButtonText: 'Cancelar',
                reverseButtons: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-' + servicioId).submit();
                }
            });
        }

        // para que los mensajes de exito se muestren solo para unos segundos
        setTimeout(function() {
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.transition = 'opacity 0.1s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 150);
            }
        }, 1500);

        /* mensaje antes de eliminar un servicio con SweetAlert2 */
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Evitar la eliminación inmediata
                    var deleteForm = this.closest('form');
                    Swal.fire({
                        title: '¿Está seguro de eliminar el servicio?',
                        text: '¡No podrás revertir esto!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, Eliminar',
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
@endsection
