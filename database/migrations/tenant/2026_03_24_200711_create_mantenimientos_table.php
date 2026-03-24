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

        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained();
            $table->foreignId('empleado_id')->nullable()->constrained();
            $table->enum('tipo', ["preventivo","correctivo","revision"]);
            $table->text('descripcion');
            $table->date('fecha_programada');
            $table->date('fecha_realizado')->nullable();
            $table->decimal('costo', 10, 2)->nullable();
            $table->string('proveedor', 150)->nullable();
            $table->enum('estado', ["programado","en_progreso","completado","cancelado"])->default('programado');
            $table->date('proxima_revision')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
