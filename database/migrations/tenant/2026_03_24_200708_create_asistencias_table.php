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
        Schema::disableForeignKeyConstraints();

        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained();
            $table->foreignId('sede_id')->constrained();
            $table->foreignId('turno_clase_id')->nullable()->constrained();
            $table->foreignId('membresia_id')->nullable()->constrained();
            $table->dateTime('fecha_hora_ingreso');
            $table->dateTime('fecha_hora_egreso')->nullable();
            $table->enum('tipo', ["clase","acceso_libre"]);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
