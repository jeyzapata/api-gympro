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

        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membresia_id')->nullable()->constrained();
            $table->foreignId('socio_id')->constrained();
            $table->foreignId('sede_id')->constrained();
            $table->foreignId('empleado_id')->constrained();
            $table->foreignId('metodo_pago_id')->constrained();
            $table->foreignId('promocion_id')->nullable()->constrained('promocions');
            $table->decimal('monto_bruto', 10, 2);
            $table->decimal('monto_descuento', 10, 2)->default(0);
            $table->decimal('monto_matricula', 10, 2)->default(0);
            $table->decimal('monto_final', 10, 2);
            $table->string('moneda', 3)->default('ARS');
            $table->boolean('es_pago_parcial')->default(false);
            $table->unsignedTinyInteger('cuota_numero')->nullable();
            $table->unsignedTinyInteger('cuota_total')->nullable();
            $table->string('concepto', 200);
            $table->string('numero_comprobante', 80)->nullable();
            $table->string('referencia_externa', 150)->nullable();
            $table->enum('estado', ["pendiente","pagado","anulado","reembolsado"])->default('pagado');
            $table->dateTime('fecha_pago');
            $table->date('fecha_vencimiento')->nullable();
            $table->unsignedBigInteger('anulado_por_id')->nullable();
            $table->string('motivo_anulacion', 200)->nullable();
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
        Schema::dropIfExists('pagos');
    }
};
