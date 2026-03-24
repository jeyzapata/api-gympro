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

        Schema::create('cajas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained();
            $table->foreignId('empleado_id')->constrained();
            $table->dateTime('fecha_apertura');
            $table->decimal('monto_apertura', 10, 2)->default(0);
            $table->dateTime('fecha_cierre')->nullable();
            $table->decimal('monto_cierre_real', 10, 2)->nullable();
            $table->decimal('monto_cierre_sistema', 10, 2)->nullable();
            $table->decimal('diferencia', 10, 2)->nullable();
            $table->enum('estado', ["abierta","cerrada"])->default('abierta');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
