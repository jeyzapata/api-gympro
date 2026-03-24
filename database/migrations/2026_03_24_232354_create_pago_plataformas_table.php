<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pago_plataformas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_tenant_id')->constrained();
            $table->foreignId('tenant_id')->constrained();
            $table->decimal('monto', 10, 2);
            $table->string('moneda', 3)->default('ARS');
            $table->string('estado', 20)->default('pendiente');
            $table->string('mp_preference_id', 200)->nullable();
            $table->string('mp_payment_id', 200)->nullable();
            $table->string('mp_status', 50)->nullable();
            $table->json('mp_response')->nullable();
            $table->dateTime('fecha_pago')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pago_plataformas');
    }
};
