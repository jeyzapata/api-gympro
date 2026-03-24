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

        Schema::create('clases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained();
            $table->foreignId('tipo_clase_id')->constrained();
            $table->foreignId('empleado_id')->constrained();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->tinyInteger('dia_semana')->nullable();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->unsignedSmallInteger('capacidad_maxima');
            $table->boolean('es_recurrente')->default(true);
            $table->date('fecha_inicio_vigencia')->nullable();
            $table->date('fecha_fin_vigencia')->nullable();
            $table->boolean('activa')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clases');
    }
};
