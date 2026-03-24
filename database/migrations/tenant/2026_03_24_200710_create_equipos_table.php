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

        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained();
            $table->foreignId('categoria_equipo_id')->constrained();
            $table->string('nombre', 150);
            $table->string('marca', 80)->nullable();
            $table->string('modelo', 80)->nullable();
            $table->string('numero_serie', 100)->nullable()->unique();
            $table->date('fecha_adquisicion')->nullable();
            $table->decimal('valor_adquisicion', 10, 2)->nullable();
            $table->enum('estado', ["operativo","en_mantenimiento","fuera_de_servicio","dado_de_baja"])->default('operativo');
            $table->string('ubicacion', 100)->nullable();
            $table->string('foto')->nullable();
            $table->text('notas')->nullable();
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
        Schema::dropIfExists('equipos');
    }
};
