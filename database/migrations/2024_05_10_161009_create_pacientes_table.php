<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('dni', 8)->unique();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('telefono', 9);
            $table->string('sexo');
            $table->date('fecha_nacimiento');
            $table->string('nombre_padre')->nullable();
            $table->string('nombre_madre')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('estado_civil')->nullable();
            $table->string('religion')->nullable();
            $table->string('grado_instruccion')->nullable();
            $table->string('procedencia')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
