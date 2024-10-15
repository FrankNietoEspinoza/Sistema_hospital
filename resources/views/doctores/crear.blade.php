@extends('layouts.app')

@section('content')
<div class="crear-doctor-container">
    <h1>Crear Doctor</h1>

    <form action="{{ route('doctores.guardar') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
            @error('nombre')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}">
            @error('apellidos')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
            @error('telefono')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="id_servicio">Servicio</label>
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
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
