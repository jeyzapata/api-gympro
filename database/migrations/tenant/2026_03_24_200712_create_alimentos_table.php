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

        Schema::create('alimentos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->decimal('calorias_por_100g', 7, 2)->nullable();
            $table->decimal('proteinas_por_100g', 7, 2)->nullable();
            $table->decimal('carbohidratos_por_100g', 7, 2)->nullable();
            $table->decimal('grasas_por_100g', 7, 2)->nullable();
            $table->decimal('fibra_por_100g', 7, 2)->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};
