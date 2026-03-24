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

        Schema::create('comida_alimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comida_diaria_id')->constrained();
            $table->foreignId('alimento_id')->constrained();
            $table->decimal('cantidad_gramos', 7, 2);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comida_alimentos');
    }
};
