@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/Pacientecrear.css')}}">
</head>
<body>
    <div class="crear-container">
        <h1><i class="fas fa-user-plus"></i> Registrar Nuevo Paciente</h1>
        <form action="{{ route('pacientes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre"><i class="fas fa-user"></i> Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido"><i class="fas fa-user-tag"></i> Apellido:</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="telefono"><i class="fas fa-phone"></i> Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Registrar</button>
        </form>
    </div>
</body>
@endsection
