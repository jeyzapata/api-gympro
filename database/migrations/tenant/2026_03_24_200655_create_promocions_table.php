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

        Schema::create('promocions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->unique()->nullable();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->enum('tipo_descuento', ["porcentaje","monto_fijo","meses_gratis"]);
            $table->decimal('valor', 10, 2);
            $table->enum('aplica_a', ["todos","plan_especifico","primera_membresia"]);
            $table->foreignId('plan_id')->nullable()->constrained('plans');
            $table->foreignId('sede_id')->nullable()->constrained();
            $table->unsignedInteger('usos_maximos')->nullable();
            $table->unsignedInteger('usos_actuales')->default(0);
            $table->boolean('un_uso_por_socio')->default(true);
            $table->dateTime('vigente_desde');
            $table->dateTime('vigente_hasta')->nullable();
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
        Schema::dropIfExists('promocions');
    }
};
