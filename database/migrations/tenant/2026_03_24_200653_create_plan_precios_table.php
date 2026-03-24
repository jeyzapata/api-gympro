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

        Schema::create('plan_precios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans');
            $table->foreignId('sede_id')->nullable()->constrained();
            $table->decimal('precio', 10, 2);
            $table->decimal('precio_matricula', 10, 2)->default(0);
            $table->string('moneda', 3)->default('ARS');
            $table->date('vigente_desde');
            $table->date('vigente_hasta')->nullable();
            $table->string('motivo_cambio', 200)->nullable();
            $table->foreignId('empleado_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plan_precios');
    }
};
