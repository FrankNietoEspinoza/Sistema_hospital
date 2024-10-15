@extends('layouts.app')

@section('content')
<head>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-4 d-flex justify-content-center">
                <img src="{{ asset('images/logo2.png') }}" alt="Logo" class="logo-img">
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h4 class="main-title">H.M.I-C.S.F</h4>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Correo Electrónico:') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ __('El correo electrónico no coincide') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Contraseña:') }}</label>
                                <div class="input-group">
                                    <!--<span class="input-group-text"><i class="bi bi-lock" id="lockIcon"></i></span>-->
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <span class="input-group-text">
                                        <i id="togglePassword" class="bi bi-eye"></i>
                                    </span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">{{ __('Ingresar') }}</button>
                                </div>
                                <div class="mt-3 text-end">
                                    <a href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.querySelector("#togglePassword");
            const password = document.querySelector("#password");

            togglePassword.addEventListener("click", function () {
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);
                this.classList.toggle("bi-eye");
                this.classList.toggle("bi-eye-slash");
            });

            password.addEventListener("input", function () {
                document.getElementById('lockIcon').style.display = this.value ? 'none' : 'block';
            });
        });
    </script>
</body>
@endsection
