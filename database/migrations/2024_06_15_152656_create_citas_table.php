<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('citas', function (Blueprint $table) {
        $table->id();
        $table->dateTime('fecha_hora');
        $table->unsignedBigInteger('id_paciente');
        $table->unsignedBigInteger('id_servicio');
        $table->unsignedBigInteger('id_recepcionista');
        $table->unsignedBigInteger('id_doctor');
        $table->string('estado');
        $table->timestamps();

        $table->foreign('id_paciente')->references('id')->on('pacientes')->onDelete('cascade');
        $table->foreign('id_servicio')->references('id')->on('servicios')->onDelete('cascade');
        $table->foreign('id_recepcionista')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_doctor')->references('id')->on('doctors')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
