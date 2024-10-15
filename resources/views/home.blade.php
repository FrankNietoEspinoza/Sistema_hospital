@extends('layouts.app')

@section('content')
    <head>
        <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    </head>

    <div class="container">
        <div class="row">
            <h3 class="text-end">
                Bienvenido, {{ Auth::user()->name }}<i class='fas fa-user-circle'></i>
            </h3>

            @if (session('perfil') == "administrador")
                <!-- Tarjeta 1 -->
                <div class="col-md-4">
                    <div class="card mb-3 text-center">
                        <div class="card-icon bg-success text-white">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <div class="card-header">REGISTRO DE SERVICIOS</div>
                        <div class="card-body">
                            <a href="{{ url('/servicio/mostrar') }}" class="btn btn-outline-success">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            
                <!-- Tarjeta 2 -->
                <div class="col-md-4">
                    <div class="card mb-3 text-center">
                        <div class="card-icon bg-info text-white">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="card-header">REGISTRO DE RECEPCIONISTAS</div>
                        <div class="card-body">
                            <a href="{{ url('/recepcionistas') }}" class="btn btn-outline-info">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            
                <!-- Tarjeta 3 -->
                <div class="col-md-4">
                    <div class="card mb-3 text-center">
                        <div class="card-icon bg-warning text-white">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-header">LISTA DE REPORTES</div>
                        <div class="card-body">         
                            <a href="{{ url('/reportes') }}" class="btn btn-outline-warning">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3 text-center">
                        <div class="card-icon bg-secondary text-white">
                            <i class='fas fa-stethoscope'></i>
                        </div>
                        <div class="card-header">LISTA DE DOCTORES</div>
                        <div class="card-body">         
                            <a href="{{ url('/doctores') }}" class="btn btn-outline-secondary">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('perfil') == "Recepcionista")
                <!-- Tarjeta 4 -->
                <div class="col-md-4">
                    <div class="card mb-3 text-center">
                        <div class="card-icon bg-danger text-white">
                            <i class="fas fa-user-injured"></i>
                        </div>
                        <div class="card-header">REGISTRO DE PACIENTES</div>
                        <div class="card-body">                      
                            <a href="{{ url('/pacientes/mostrar') }}" class="btn btn-outline-danger">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            
                <!-- Tarjeta 5 -->
                <div class="col-md-4">
                    <div class="card mb-3 text-center">
                        <div class="card-icon bg-primary text-white">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="card-header">CITAS MEDICAS</div>
                        <div class="card-body">
                            <a href="{{ url('/citas/mostrar') }}" class="btn btn-outline-primary">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
