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

        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ["fijo","pase_dia","clases_sueltas"]);
            $table->unsignedInteger('duracion_dias')->nullable();
            $table->unsignedInteger('cantidad_clases')->nullable();
            $table->boolean('permite_congelamiento')->default(false);
            $table->unsignedSmallInteger('max_dias_congelamiento')->default(0);
            $table->unsignedTinyInteger('max_veces_congelamiento')->default(0);
            $table->boolean('permite_acceso_multisede')->default(false);
            $table->boolean('activo')->default(true);
            $table->unsignedTinyInteger('orden_display')->default(0);
            $table->string('color_ui', 7)->nullable();
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
        Schema::dropIfExists('plans');
    }
};
