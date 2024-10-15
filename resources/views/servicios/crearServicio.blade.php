@extends('layouts.app')

@section('content')

<head>
    <!-- Enlace al archivo CSS personalizado -->
    <link href="{{ asset('css/servicio.css') }}" rel="stylesheet">
</head>

<body>

    <div class="crear-container mt-5">
        <!-- Posición del botón y el título -->
        <div class="d-flex justify-content-center align-items-center mb-4 text-white position-relative">
            <h1 class="flex-grow-1 text-center">Crear Servicio</h1>
            <a href="{{ route('servicios.mostrar') }}" class="btn btn-primary position-absolute end-0">MOSTRAR SERVICIO</a>
        </div>

        <!-- Muestra de alerta de éxito 
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        -->

        <!-- Encapsulado del formulario -->
        <div class="card shadow-lg">
            <div class="card-body">
                <form method="POST" action="{{ route('servicios.guardar') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen del servicio:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_servicio" class="form-label">Nombre del Servicio:</label>
                        <select class="form-control" id="nombre_servicio" name="nombre_servicio" required>
                            <option value="" disabled selected>Seleccionar Servicio</option>
                            <option value="Pediatria">Pediatría</option>
                            <option value="Consultoria Neurologia">Consultoria Neurologia</option>
                            <option value="Ginecologia-ARO">Ginecologia-ARO</option>
                            <option value="Ecografias Obstetricas">Ecografias Obstetricas</option>
                            <option value="Cardiologia">Cardiologia</option>
                            <option value="Cardiologia Procedimientos">Cardiologia Procedimientos</option>
                            <option value="Medicina Integral">Medicina Integral</option>
                            <option value="Psiquiatria">Psiquiatria</option>
                            <option value="Consultoria de Nutricion">Consultoria de Nutrición</option>
                            <option value="Rayos X">Rayos X</option>
                            <option value="Ecografias Partes Blandas">Ecografias Partes Blandas</option>
                            <option value="Ecografias General">Ecografias General</option>
                            <option value="Psicologia">Psicología</option>
                            <option value="Odontologia">Odontología</option>
                            
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cupos_disponibles" class="form-label">Cupos Disponibles:</label>
                        <input type="number" class="form-control" id="cupos_disponibles" name="cupos_disponibles" min="0" max="20" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">CREAR</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

@endsection
