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

        Schema::create('plan_nutricionals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained();
            $table->foreignId('empleado_id')->constrained();
            $table->string('nombre', 150);
            $table->enum('objetivo', ["perdida_peso","ganancia_muscular","mantenimiento","rendimiento","otro"]);
            $table->text('descripcion')->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_nutricionals');
    }
};
