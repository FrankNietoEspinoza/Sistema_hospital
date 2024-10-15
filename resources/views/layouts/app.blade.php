<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- esto es icono de navegacion -->
    <link rel="icon" href="{{ asset('images/logo2.png')}}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    
    <!-- estilo css -->

    <!-- Otros metadatos y enlaces CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        @if (!request()->is('login') && !request()->is('register'))
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        <img src="{{ asset('images/hospital.png') }}" alt="Logo" style="height: 63px;"> <!-- Reemplaza con el nombre y la ubicación al logo -->
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            @auth
                                    
                                    @if (session('perfil')=="administrador")
                                        <li class="pt-2 pb-3 space-y-1">
                                            <a class ="nav-link"  style="color:rgb(1, 35, 206)" href="/servicio/mostrar">Servicio</a>
                                        </li>
                                    @endif
                                    @if (session('perfil')=="administrador")
                                        <li class="pt-2 pb-3 space-y-1">
                                            <a class ="nav-link"  style="color:rgb(1, 35, 206)" href="/recepcionistas">Recepcionistas</a>
                                        </li>
                                    @endif
                                    @if (session('perfil')=="administrador")
                                        <li class="pt-2 pb-3 space-y-1">
                                            <a class ="nav-link"  style="color:rgb(1, 35, 206)" href="/reportes">Reportes</a>
                                        </li>
                                    @endif
                                    @if (session('perfil')=="administrador")
                                        <li class="pt-2 pb-3 space-y-1">
                                            <a class ="nav-link"  style="color:rgb(1, 35, 206)" href="/doctores">Doctores</a>
                                        </li>
                                    @endif

                                    <!--EN ESTA PARTE ES PARA EL USUARIO, TODAS LAS TABLAS QUE UTILIZARA EL RECEPCIONISTA-->
                                    @if (session('perfil')=="Recepcionista")
                                        <li class="pt-2 pb-3 space-y-1">
                                            <a class ="nav-link"  style="color:rgb(1, 35, 206)" href="/pacientes/mostrar">Pacientes</a>
                                        </li>
                                    @endif
                                    @if (session('perfil')=="Recepcionista")
                                        <li class="pt-2 pb-3 space-y-1">
                                            <a class ="nav-link"  style="color:rgb(1, 35, 206)" href="/citas/mostrar">Cita</a>
                                        </li>
                                    @endif
                            @endauth
                        </ul>

                        

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class='fas fa-user-circle'></i> {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                                        <i class="fas fa-sign-out-alt"></i> 
                                            {{ __('Cerrar Sessión') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
        <main class="py-4">
            @yield('content')   
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
