<?php

use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DniController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\HorarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//ESTA PARTE ES PARA QUE AL MOMENTO DE INICIAR TE APAREZCA EL LOGIN INICIAL
Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ESTAS SON LAS RUTAS PARA LOS PACIENTES
Route::get('/pacientes/crear', [PacienteController::class,'crear'])->name('pacientes.crearPaciente');
Route::post('/pacientes/guardar', [PacienteController::class,'store'])->name('pacientes.store');
Route::get('/pacientes/mostrar', [PacienteController::class,'mostrar'])->name('pacientes.mostrar');
Route::get('/pacientes/{paciente}/editar', [PacienteController::class, 'editar'])->name('pacientes.editar');
Route::put('/pacientes/{paciente}', [PacienteController::class, 'actualizar'])->name('pacientes.actualizar');
Route::delete('/pacientes/{paciente}', [PacienteController::class, 'eliminar'])->name('pacientes.eliminar');
Route::get('/consulta-dni', [DniController::class, 'consultaDni'])->name('consulta.dni');


// EN ESTA PARTE SE CREARAN LOS SERVICIOS 
Route::get('/servicio/crear', [ServicioController::class, 'crear'])->name('servicios.crearServicio');
Route::post('/servicio/guardar', [ServicioController::class, 'guardar'])->name('servicios.guardar');
Route::get('/servicio/mostrar', [ServicioController::class, 'mostrar'])->name('servicios.mostrar');
Route::put('/servicio/{servicio}', [ServicioController::class, 'actualizar'])->name('servicios.actualizar');
Route::delete('/servicio/{servicio}', [ServicioController::class, 'eliminar'])->name('servicios.eliminar');

//EN ESTA PARTE SON LAS RUTAS PARA LAS CITAS
Route::middleware('auth')->group(function (){
    Route::get('/citas/crear', [CitaController::class, 'crear'])->name('citas.crear');
    Route::post('/citas/guardar', [CitaController::class, 'guardar'])->name('citas.guardar');
    Route::get('/citas/mostrar', [CitaController::class, 'mostrar'])->name('citas.mostrar');
    Route::get('/citas/{cita}/editar', [CitaController::class, 'editar'])->name('citas.editar');
    Route::put('/citas/{cita}', [CitaController::class, 'actualizar'])->name('citas.actualizar');
    Route::delete('/citas/{cita}', [CitaController::class, 'eliminar'])->name('citas.eliminar');
    Route::get('/citas/seleccionar-hora', [CitaController::class, 'seleccionarHora'])->name('citas.seleccionarHora');
    Route::get('/obtener-horas-ocupadas', [CitaController::class, 'obtenerHorasOcupadas']);
    Route::get('/citas/{cita}/detalle', [CitaController::class, 'detalle'])->name('citas.detalle');
});

Route::get('/recepcionistas', [UserController::class, 'index'])->name('recepcionistas.index');
Route::get('/recepcionistas/crear', [UserController::class, 'crear'])->name('recepcionistas.crear');
Route::post('/recepcionistas', [UserController::class, 'guardar'])->name('recepcionistas.guardar');
Route::delete('/recepcionistas/{id}', [UserController::class, 'eliminar'])->name('recepcionistas.eliminar');

//vista para la vicualizacion de reportes de cada servicio

Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::post('/reportes/buscar', [ReporteController::class, 'buscar'])->name('reportes.buscar');

//Ruta de doctores
Route::get('/doctores', [DoctorController::class, 'index'])->name('doctores.index');
Route::get('/doctores/crear', [DoctorController::class, 'crear'])->name('doctores.crear');
Route::post('/doctores', [DoctorController::class, 'guardar'])->name('doctores.guardar');
Route::get('/doctores/{doctor}', [DoctorController::class, 'mostrar'])->name('doctores.mostrar');
Route::get('/doctores/{doctor}/editar', [DoctorController::class, 'editar'])->name('doctores.editar');
Route::put('/doctores/{doctor}', [DoctorController::class, 'actualizar'])->name('doctores.actualizar');
Route::delete('/doctores/{doctor}', [DoctorController::class, 'eliminar'])->name('doctores.eliminar');


Route::get('/horarios/crear/{doctor}', [HorarioController::class, 'crear'])->name('horarios.crear');
Route::post('/horarios', [HorarioController::class, 'guardar'])->name('horarios.guardar');

Route::delete('/horarios/eliminarTodos/{doctor}', [HorarioController::class, 'eliminarTodos'])->name('horarios.eliminarTodos');


Route::get('/obtener-doctores-disponibles', [CitaController::class, 'obtenerDoctoresDisponibles']);

//hoja d emergencia
Route::get('/formatos/hoja_de_emergencia', function () {
    return response()->file(resource_path('views/formatos/hoja_de_emergencia.html'));
});
//hoja de consulta 
Route::get('formatos/hoja_consulta',function (){
    return response()->file(resource_path('views/formatos/hoja_consulta.html'));
}); 
