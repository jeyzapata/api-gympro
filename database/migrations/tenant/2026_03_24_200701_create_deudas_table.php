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

        Schema::create('deudas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('socio_id')->constrained();
            $table->foreignId('membresia_id')->nullable()->constrained();
            $table->foreignId('sede_id')->constrained();
            $table->string('concepto', 200);
            $table->decimal('monto', 10, 2);
            $table->date('fecha_generacion');
            $table->date('fecha_vencimiento')->nullable();
            $table->enum('estado', ["pendiente","pagada","anulada"])->default('pendiente');
            $table->foreignId('pago_id')->nullable()->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudas');
    }
};
