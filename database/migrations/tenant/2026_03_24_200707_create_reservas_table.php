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

        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turno_clase_id')->constrained();
            $table->foreignId('socio_id')->constrained();
            $table->foreignId('membresia_id')->nullable()->constrained();
            $table->enum('estado', ["reservada","confirmada","asistio","ausente","cancelada"])->default('reservada');
            $table->dateTime('fecha_reserva');
            $table->dateTime('fecha_cancelacion')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
