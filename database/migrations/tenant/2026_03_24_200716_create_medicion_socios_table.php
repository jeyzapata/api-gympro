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

        Schema::create('medicion_socios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained();
            $table->foreignId('empleado_id')->nullable()->constrained();
            $table->date('fecha');
            $table->decimal('peso_kg', 5, 2)->nullable();
            $table->decimal('altura_cm', 5, 2)->nullable();
            $table->decimal('imc', 4, 2)->nullable();
            $table->decimal('porcentaje_grasa', 5, 2)->nullable();
            $table->decimal('masa_muscular_kg', 5, 2)->nullable();
            $table->decimal('cintura_cm', 5, 2)->nullable();
            $table->decimal('cadera_cm', 5, 2)->nullable();
            $table->decimal('pecho_cm', 5, 2)->nullable();
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
        Schema::dropIfExists('medicion_socios');
    }
};
