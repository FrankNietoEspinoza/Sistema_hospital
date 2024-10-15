@extends('layouts.app')

@section('content')
<head>
    <link rel="stylesheet" href="{{ asset('css/mostrarCita.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>
<body>
    <div class="mostrar-cita-container">
        <h2><i class="bi bi-clipboard2-check-fill"></i>Lista de Citas</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearCitaModal">
            <i class="fas fa-plus"></i> Registrar 
        </button>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>{{ session('error') }}
            </div>
        @endif
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">N°</th>
                    <th><i class="fas fa-calendar-alt icon"></i> Fecha</th>
                    <th><i class="fas fa-clock icon"></i> Hora</th>
                    <th><i class="fas fa-user icon"></i> Paciente</th>
                    <th><i class='fas fa-user-md'></i> Servicio</th>
                    <th class="text-center"><i class="fas fa-user-md icon"></i> Doctor</th>
                    <th class="text-center"><i class="fas fa-user icon"></i> Recepcionista</th>
                    <!--<th><i class="fas fa-info-circle icon"></i> Estado</th>-->
                    <th class="text-center"><i class="fas fa-clock icon"></i> Turno</th>
                    <th><i class="fas fa-cogs icon"></i> Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php $contador = 1; @endphp
                @foreach($citas as $cita)
                    <tr>
                        <td class="text-center">{{ $contador++ }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('d-m-Y') }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($cita->fecha_hora)->format('h:i A') }}</td>
                        <td class="text-center">{{ $cita->paciente->nombre }}</td>
                        <td class="text-center">{{ $cita->servicio->Nombre_servicio }}</td>
                        <td class="text-center" style="font-size: 0.8em;">{{ $cita->doctor->nombre }} {{ $cita->doctor->apellidos }}</td>
                        <td class="text-center">{{ $cita->recepcionista->name }}</td>
                        <!--<td class="text-center">{{ $cita->estado }}</td>-->
                        <td class="text-center"> 
                            @php
                                $hora = \Carbon\Carbon::parse($cita->fecha_hora)->format('H:i');
                                if($hora >= '07:00' && $hora <= '13:00') {
                                    echo '<span style="color: green;">MAÑANA</span>';
                                } elseif($hora >= '13:15' && $hora <= '19:00') {
                                    echo '<span style="color: red;">TARDE</span>';
                                }
                            @endphp
                        </td>
                        <td>
                            <form action="{{ route('citas.eliminar', $cita->id) }}" method="POST" class="delete-form" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-btn">
                                    <i class="fas fa-trash-alt icon"></i>
                                </button>
                            </form>

                            <button class="btn btn-info" data-toggle="modal" data-target="#detalleCitaModal" data-cita="{{ $cita }}">
                                <i class="fas fa-eye icon"></i> 
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para crear cita -->
    <div class="modal fade" id="crearCitaModal" tabindex="-1" role="dialog" aria-labelledby="crearCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="crearCitaModalLabel">Crear Cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('citas.guardar') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="fecha"><i class="fas fa-calendar-day icon"></i> Fecha:</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="id_paciente"><i class="fas fa-user icon"></i> Paciente:</label>
                            <select name="id_paciente" class="form-control" required>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}">{{ $paciente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_servicio"><i class='fas fa-user-md'></i> Servicio:</label>
                            <select name="id_servicio" class="form-control" required>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->Nombre_servicio }} ({{ $servicio->Cupos_disponibles }} cupos disponibles)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_doctor"><i class='fas fa-user-md'></i> Doctor:</label>
                            <select name="id_doctor" id="id_doctor" class="form-control" required>
                                <option value="">Seleccione un doctor</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="turno"><i class="fas fa-clock icon"></i> Turno:</label>
                            <select name="turno" id="turno" class="form-control" required>
                                <option value="">Seleccione un turno</option>
                                <option value="mañana">Mañana</option>
                                <option value="tarde">Tarde</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hora"><i class="fas fa-clock icon"></i> Hora:</label>
                            <div id="hora-selector" class="hora-selector">
                                <p>Seleccione un turno primero</p>
                            </div>
                            <input type="hidden" name="hora" id="hora" required>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save icon"></i> Crear Cita</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para el Detalle de la Cita -->
    <div class="modal fade" id="detalleCitaModal" tabindex="-1" role="dialog" aria-labelledby="detalleCitaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detalleCitaModalLabel"><i class="fas fa-info-circle"></i> Detalle de la Cita</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--<h4>Detalles de la Cita</h4>-->
                    <p><strong>Paciente:</strong> <span id="detalle-paciente"></span></p>
                    <p><strong>Servicio:</strong> <span id="detalle-servicio"></span></p>
                    <p><strong>Recepcionista:</strong> <span id="detalle-recepcionista"></span></p>
                    <p><strong>Fecha:</strong> <span id="detalle-fecha"></span></p>
                    <p><strong>Hora:</strong> <span id="detalle-hora"></span></p>
                    <p><strong>Estado:</strong> <span id="detalle-estado"></span></p>
                    <p><strong>Turno:</strong> <span id="detalle-turno"></span></p>
                    <!--<button id="printButton" class="no-print btn btn-primary">
                    <i class='fas fa-print'></i> Imprimir
                    </button>-->

                    <!--Botones de impresion -->
                    <button id="printConsultaButton" class="no-print btn btn-primary">
                        <i class='fas fa-print'></i> Imprimir Consulta
                    </button>
                    <button id="printEmergenciaButton" class="no-print btn btn-danger">
                        <i class='fas fa-print'></i> Imprimir Emergencia
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para confirmar la eliminación-->
    <div class="modal fade" id="confirmarEliminarcionModal" tabindex="-1" role="dialog" aria-labelledby="confirmarEliminacionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="modal-icon">
                        <i class='fas fa-exclamation-triangle text-warning' style='font-size:60px'></i>
                    </div>
                    <h5 class="modal-title my-3" id="confirmarEliminacionModalLabel">Confirmar Eliminación</h5>
                    <p class="mb-4">¿Estás seguro de que deseas eliminar esta cita?</p>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
                

    <script>
        document.addEventListener('DOMContentLoaded', function() 
        {
            const turnoSelect = document.getElementById('turno');
            const horaSelector = document.getElementById('hora-selector');
            const horaInput = document.getElementById('hora');
            const fechaInput = document.querySelector('input[name="fecha"]');
            const servicioSelect = document.querySelector('select[name="id_servicio"]');

            turnoSelect.addEventListener('change', updateHours);
            fechaInput.addEventListener('change', updateHours);
            servicioSelect.addEventListener('change', updateHours);

            function updateHours() {
                const turno = turnoSelect.value;
                const fecha = fechaInput.value;
                const id_servicio = servicioSelect.value;

                if (!turno || !fecha || !id_servicio) {
                    return;
                }

                fetch(`/obtener-horas-ocupadas?fecha=${fecha}&id_servicio=${id_servicio}`)
                    .then(response => response.json())
                    .then(ocupadas => {
                        horaSelector.innerHTML = ''; // Limpiar las opciones anteriores

                        if (turno === 'mañana') {
                            addOptions(horaSelector, '07:00', '13:00', 15, ocupadas);
                        } else if (turno === 'tarde') {
                            addOptions(horaSelector, '13:15', '19:00', 15, ocupadas);
                        }
                    });
            }

            function addOptions(container, start, end, interval, ocupadas) {
                let startTime = moment(start, 'HH:mm');
                const endTime = moment(end, 'HH:mm');

                while (startTime <= endTime) {
                    const button = document.createElement('button');
                    const timeFormatted = startTime.format('HH:mm');

                    button.textContent = startTime.format('hh:mm A');
                    button.value = timeFormatted;
                    button.className = 'hora';

                    if (ocupadas.includes(timeFormatted)) {
                        button.classList.add('ocupada');
                    }   

                    button.addEventListener('click', function(event) {
                        event.preventDefault(); // -> esta parte evita que el formulario se envie cuando se selecciona la hora
                        document.querySelectorAll('.hora').forEach(btn => btn.classList.remove('seleccionado'));
                        this.classList.add('seleccionado');
                        horaInput.value = this.value;
                    });

                    container.appendChild(button);
                    startTime.add(interval, 'minutes');
                }
            }
        });
        // para que los mensajes se muestren solo por unos segundos
        setTimeout(function(){
            var alert = document.querySelector('.alert');
            if(alert) {
                alert.style.transition = 'opacity 0.1s';
                alert.style.opacity = '0';
                setTimeout(function(){
                    alert.style.display = 'none';
                }, 150);
            }
        }, 1500);

        document.addEventListener('DOMContentLoaded', function() {
            $('#detalleCitaModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var cita = button.data('cita'); // Extract info from data-* attributes

                // Update the modal's content.
                var modal = $(this);
                modal.find('#detalle-paciente').text(cita.paciente.nombre);
                modal.find('#detalle-servicio').text(cita.servicio.Nombre_servicio);
                modal.find('#detalle-recepcionista').text(cita.recepcionista.name);
                //Separación de la fecha y hora:
                var fechaHora = moment(cita.fecha_hora);
                modal.find('#detalle-fecha').text(fechaHora.format('DD-MM-YYYY'));
                modal.find('#detalle-hora').text(fechaHora.format('h:mm A'));
                
                modal.find('#detalle-estado').text(cita.estado);

                // Calcular el turno si no está disponible directamente en los datos
                var hora = moment(cita.fecha_hora).format('HH:mm');
                var turno = '';
                if (hora >= '07:00' && hora <= '13:00') {
                    turno = 'Mañana';
                } else if (hora >= '13:15' && hora <= '19:00') {
                    turno = 'Tarde';
                } else {
                    turno = 'Indefinido';
                }
                modal.find('#detalle-turno').text(turno);
                    });
                });

            // SweetAlert2 para confirmar la eliminación
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                const deleteBtn = form.querySelector('.delete-btn');
                
                deleteBtn.addEventListener('click', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: '¿Estás seguro de eliminar esta Cita Medica?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });


           

            /* Botón de impresión boleta
                            document.addEventListener('DOMContentLoaded', function() {
                                document.getElementById('printButton').addEventListener('click', function() {
                                    var modalContent = document.querySelector('#detalleCitaModal .modal-body').innerHTML;
                                    var printWindow = window.open('', '', 'height=600,width=800');
                                    printWindow.document.write('<html><head><title>Detalle de la Cita</title>');
                                    printWindow.document.write('<style>');
                                    printWindow.document.write('body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; color: #444; line-height: 1.6; margin: 20px; }'); //estilo para el cuerpo del documento
                                    printWindow.document.write('h3 { text-align: center; color: #009688; margin-bottom: 10px; }'); // Estilo para el título principal
                                    printWindow.document.write('h4 { text-align: center; color: #444; border-bottom: 2px solid #009688; padding-bottom: 10px; margin-bottom: 20px; }'); // Estilo para el subtítulo con borde inferior
                                    printWindow.document.write('img { display: block; margin: 0 auto; max-width: 150px; }'); // Estilo para la imagen del logo
                                    printWindow.document.write('p { margin-bottom: 15px; }'); // Estilo para los párrafos
                                    printWindow.document.write('table { width: 100%; border-collapse: collapse; margin-top: 20px; }'); // Estilo para las tablas
                                    printWindow.document.write('table, th, td { border: 1px solid #ddd; }');
                                    printWindow.document.write('th, td { padding: 12px; text-align: left; }');
                                    printWindow.document.write('th { background-color: #009688; color: white; }');
                                    printWindow.document.write('@media print { .no-print { display: none; } }');
                                    printWindow.document.write('</style>');
                                    printWindow.document.write('</head><body>');
                                    printWindow.document.write('<h3>Hospital Materno Infantil Carlos Showing Ferrari</h3>');
                                    printWindow.document.write('<div><img src="/images/hospital.png" alt="Logo"></div>');
                                    printWindow.document.write('<h4>Detalle de la Cita</h4>');
                                    printWindow.document.write(modalContent);
                                    printWindow.document.write('</body></html>');
                                    printWindow.document.close();
                                    printWindow.print(); // Iniciar el proceso de impresión
                                });
                            });
        */
            
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInput = document.querySelector('input[name="fecha"]');
            const servicioSelect = document.querySelector('select[name="id_servicio"]');
            const doctorSelect = document.getElementById('id_doctor');

            // Función para actualizar los doctores disponibles
            function updateDoctors() {
                const fecha = fechaInput.value;
                const id_servicio = servicioSelect.value;

                if (!fecha || !id_servicio) {
                    return;
                }

                // Llamada AJAX para obtener los doctores disponibles
                fetch(`/obtener-doctores-disponibles?fecha=${fecha}&id_servicio=${id_servicio}`)
                    .then(response => response.json())
                    .then(doctores => {
                        // Limpiar las opciones anteriores
                        doctorSelect.innerHTML = '<option value="">Seleccione un doctor</option>';
                        
                        // Agregar los doctores disponibles como opciones
                        doctores.forEach(doctor => {
                            const option = document.createElement('option');
                            option.value = doctor.id;
                            option.textContent = `${doctor.nombre} ${doctor.apellidos}`;
                            doctorSelect.appendChild(option);
                        });
                    });
            }

            // Eventos para actualizar los doctores cuando cambien la fecha o el servicio
            fechaInput.addEventListener('change', updateDoctors);
            servicioSelect.addEventListener('change', updateDoctors);
        });

        let citaSeleccionada; // Variable global para almacenar los datos de la cita seleccionada

            document.addEventListener('DOMContentLoaded', function() {
                // Al abrir el modal de detalles de la cita
                $('#detalleCitaModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    citaSeleccionada = button.data('cita'); // Guardar los datos de la cita en la variable global

                    // Actualizar contenido del modal
                    var modal = $(this);
                    modal.find('#detalle-paciente').text(citaSeleccionada.paciente.nombre);
                    modal.find('#detalle-servicio').text(citaSeleccionada.servicio.Nombre_servicio);
                    modal.find('#detalle-recepcionista').text(citaSeleccionada.recepcionista.name);
                    var fechaHora = moment(citaSeleccionada.fecha_hora);
                    modal.find('#detalle-fecha').text(fechaHora.format('DD-MM-YYYY'));
                    modal.find('#detalle-hora').text(fechaHora.format('h:mm A'));
                    modal.find('#detalle-estado').text(citaSeleccionada.estado);
                    var hora = moment(citaSeleccionada.fecha_hora).format('HH:mm');
                    var turno = (hora >= '07:00' && hora <= '13:00') ? 'Mañana' : (hora >= '13:15' && hora <= '19:00') ? 'Tarde' : 'Indefinido';
                    modal.find('#detalle-turno').text(turno);
                });
            });


        //para el boton para consulta externa :
        document.addEventListener('DOMContentLoaded', function() {
            // Botón de impresión para la emergencia
            document.getElementById('printConsultaButton').addEventListener('click', function() {
                imprimirConsulta();
            });

            // Función para imprimir la hoja de emergencia
            function imprimirConsulta() 
            {
                // Cargar la plantilla de emergencia HTML
                fetch('/formatos/hoja_consulta')
                    .then(response => response.text())
                    .then(html => 
                    {
                        // Crear una nueva ventana para la impresión
                        var printWindow = window.open('', '', 'height=1000,width=800');
                        printWindow.document.write(html);
                        printWindow.document.close();

                        // Insertar los datos dinámicos en el documento HTML cargado
                        if (citaSeleccionada) {
                            printWindow.document.getElementById('nombre-paciente').textContent = citaSeleccionada.paciente.nombre + ' ' + citaSeleccionada.paciente.apellido;
                            printWindow.document.getElementById('sexo-paciente').textContent = citaSeleccionada.paciente.sexo;
                            printWindow.document.getElementById('fecha-nacimiento').textContent = citaSeleccionada.paciente.fecha_nacimiento;
                            printWindow.document.getElementById('procedencia').textContent = citaSeleccionada.paciente.procedencia;
                            printWindow.document.getElementById('nombre-padre').textContent =citaSeleccionada.paciente.nombre_padre;
                            printWindow.document.getElementById('nombre-madre').textContent =citaSeleccionada.paciente.nombre_madre;
                            printWindow.document.getElementById('domicilio-actual').textContent = citaSeleccionada.paciente.domicilio;
                            printWindow.document.getElementById('dni').textContent = citaSeleccionada.paciente.dni;
                            printWindow.document.getElementById('estado-civil').textContent = citaSeleccionada.paciente.estado_civil;
                            printWindow.document.getElementById('religion').textContent = citaSeleccionada.paciente.religion;
                            printWindow.document.getElementById('grado-instruccion').textContent = citaSeleccionada.paciente.grado_instruccion;
                            
                            // Agrega otros datos según sea necesario
                        } else {
                            alert('No se ha seleccionado ninguna cita.');
                        }

                        // Iniciar el proceso de impresión
                        printWindow.print();
                    });
            }
        });

        //para el boton para emergencia :
        document.addEventListener('DOMContentLoaded', function() {
            // Botón de impresión para la emergencia
            document.getElementById('printEmergenciaButton').addEventListener('click', function() {
                imprimirEmergencia();
            });

            // Función para imprimir la hoja de emergencia
            function imprimirEmergencia() 
            {
                // Cargar la plantilla de emergencia HTML
                fetch('/formatos/hoja_de_emergencia')
                    .then(response => response.text())
                    .then(html => 
                    {
                        // Crear una nueva ventana para la impresión
                        var printWindow = window.open('', '', 'height=1000,width=800');
                        printWindow.document.write(html);
                        printWindow.document.close();

                        // Insertar los datos dinámicos en el documento HTML cargado
                        if (citaSeleccionada) {
                            printWindow.document.getElementById('nombre-paciente').textContent = citaSeleccionada.paciente.nombre + ' ' + citaSeleccionada.paciente.apellido;
                            printWindow.document.getElementById('sexo-paciente').textContent = citaSeleccionada.paciente.sexo;
                            printWindow.document.getElementById('fecha-nacimiento').textContent = citaSeleccionada.paciente.fecha_nacimiento;
                            printWindow.document.getElementById('procedencia').textContent = citaSeleccionada.paciente.procedencia;
                            printWindow.document.getElementById('nombre-padre').textContent =citaSeleccionada.paciente.nombre_padre;
                            printWindow.document.getElementById('nombre-madre').textContent =citaSeleccionada.paciente.nombre_madre;
                            printWindow.document.getElementById('domicilio-actual').textContent = citaSeleccionada.paciente.domicilio;
                            printWindow.document.getElementById('dni').textContent = citaSeleccionada.paciente.dni;
                            printWindow.document.getElementById('estado-civil').textContent = citaSeleccionada.paciente.estado_civil;
                            printWindow.document.getElementById('religion').textContent = citaSeleccionada.paciente.religion;
                            printWindow.document.getElementById('grado-instruccion').textContent = citaSeleccionada.paciente.grado_instruccion;
                            
                            // Agrega otros datos según sea necesario
                        } else {
                            alert('No se ha seleccionado ninguna cita.');
                        }

                        // Iniciar el proceso de impresión
                        printWindow.print();
                    });
            }
        });



    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
@endsection
