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

        Schema::create('turno_clases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clase_id')->constrained();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->foreignId('instructor_id')->nullable()->constrained('empleados');
            $table->enum('estado', ["programado","en_curso","finalizado","cancelado"])->default('programado');
            $table->unsignedSmallInteger('capacidad_maxima')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turno_clases');
    }
};
