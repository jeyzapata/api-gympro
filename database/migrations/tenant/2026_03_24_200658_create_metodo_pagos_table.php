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

        Schema::create('metodo_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60)->unique();
            $table->enum('tipo', ["efectivo","digital","tarjeta","otro"]);
            $table->boolean('requiere_referencia')->default(false);
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
        Schema::dropIfExists('metodo_pagos');
    }
};
