@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">{{ __('Editar Paciente') }}</div>
                <div class="card-body">
                    <form action="{{ route('pacientes.actualizar', $paciente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="nombre">{{ __('Nombre') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" value="{{ $paciente->nombre }}" required>
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="apellido">{{ __('Apellido') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-lines-fill"></i></span>
                                <input type="text" class="form-control @error('apellido') is-invalid @enderror" name="apellido" id="apellido" value="{{ $paciente->apellido }}" required>
                                @error('apellido')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="telefono">{{ __('Teléfono') }}</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                                <input type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" id="telefono" value="{{ $paciente->telefono }}" required>
                                @error('telefono')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">{{ __('Actualizar') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
