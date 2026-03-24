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

        Schema::create('membresias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained();
            $table->foreignId('plan_id')->constrained('plans');
            $table->foreignId('plan_precio_id')->constrained();
            $table->foreignId('sede_id')->constrained();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->unsignedInteger('clases_restantes')->nullable();
            $table->enum('estado', ["activa","vencida","congelada","cancelada","pendiente_pago"])->default('activa');
            $table->date('fecha_congelamiento')->nullable();
            $table->date('fecha_descongelamiento')->nullable();
            $table->unsignedSmallInteger('dias_congelados_usados')->default(0);
            $table->unsignedTinyInteger('veces_congelado')->default(0);
            $table->boolean('auto_renovar')->default(false);
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
        Schema::dropIfExists('membresias');
    }
};
