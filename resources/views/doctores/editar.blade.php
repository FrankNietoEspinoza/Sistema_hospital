@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Doctor</h1>

    <!-- Formulario para editar los datos del doctor -->
    <form action="{{ route('doctores.actualizar', $doctor->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $doctor->nombre) }}">
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $doctor->apellidos) }}">
            @error('apellidos')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $doctor->telefono) }}">
            @error('telefono')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_servicio">Servicio</label>
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
@endsection
