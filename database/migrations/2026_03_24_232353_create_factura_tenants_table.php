<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factura_tenants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained();
            $table->foreignId('plan_plataforma_id')->constrained();
            $table->string('numero_factura', 50)->unique();
            $table->decimal('monto', 10, 2);
            $table->string('moneda', 3)->default('ARS');
            $table->date('periodo_inicio');
            $table->date('periodo_fin');
            $table->date('fecha_vencimiento');
            $table->string('estado', 20)->default('pendiente');
            $table->date('fecha_pago')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factura_tenants');
    }
};
