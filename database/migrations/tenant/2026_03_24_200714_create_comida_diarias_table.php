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

        Schema::create('comida_diarias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_nutricional_id')->constrained('plan_nutricionals');
            $table->tinyInteger('dia_semana');
            $table->enum('tipo_comida', ["desayuno","almuerzo","merienda","cena","colacion"]);
            $table->time('hora_sugerida')->nullable();
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
        Schema::dropIfExists('comida_diarias');
    }
};
