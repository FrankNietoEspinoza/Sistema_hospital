@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/recepcionistaCrear.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="listar-container">
        <h1><!--<i class="fas fa-users"></i>--> Recepcionistas</h1>
        <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#crearRecepcionistaModal">
            <i class="fas fa-user-plus"></i> Crear
        </button>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th> N°</th>
                    <th><i class="fas fa-user"></i> Nombre</th>
                    <th><i class="fas fa-envelope"></i> Email</th>
                    <th><i class="fas fa-id-badge"></i> Perfil</th>
                    <th><i class="fas fa-cogs"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = 1; @endphp
                @foreach($recepcionistas as $recepcionista)
                    <tr>
                        <td>{{ $contador++ }}</td>
                        <td>{{ $recepcionista->name }}</td>
                        <td>{{ $recepcionista->email }}</td>
                        <td>{{ $recepcionista->perfil }}</td>
                        <td>
                            <form action="{{ route('recepcionistas.eliminar', $recepcionista->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirmarEliminacion(event)">
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
    </div>

    <!-- Modal para crear -->
    <div class="modal fade" id="crearRecepcionistaModal" tabindex="-1" role="dialog" aria-labelledby="crearRecepcionistaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="crearRecepcionistaModalLabel">
                        <i class="fas fa-plus"></i> Recepcionista
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('recepcionistas.guardar') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name"><i class="fas fa-user"></i> Nombre:</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email"><i class="fas fa-envelope"></i> Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password"><i class="fas fa-lock"></i> Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmar Contraseña:</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Crear
                        </button>
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
                }, 150);
            }
        }, 1500);

        /*mensaje de eliminacion */
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButtons =document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    var deleteForm = this.closest('form');
                    Swal.fire({
                        title: '¿Está seguro de eliminar a este usuario?',
                        text: '¡No podrás revertir esto!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons:false
                    }).then((result) => {
                        if (result.isConfirmed){
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
