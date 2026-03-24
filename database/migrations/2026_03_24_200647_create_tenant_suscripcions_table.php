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

        Schema::create('tenant_suscripcions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->string('plan_anterior', 30)->nullable();
            $table->string('plan_nuevo', 30);
            $table->string('motivo', 200)->nullable();
            $table->decimal('precio_mensual', 10, 2);
            $table->date('activa_desde');
            $table->date('activa_hasta')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_suscripcions');
    }
};
