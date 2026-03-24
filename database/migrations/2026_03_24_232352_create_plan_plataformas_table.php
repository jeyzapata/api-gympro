<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plan_plataformas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->string('slug', 80)->unique();
            $table->decimal('precio_mensual', 10, 2);
            $table->string('moneda', 3)->default('ARS');
            $table->integer('max_sedes')->default(1);
            $table->integer('max_empleados')->default(10);
            $table->integer('max_socios')->default(200);
            $table->json('features')->nullable();
            $table->boolean('activo')->default(true);
            $table->unsignedTinyInteger('orden_display')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plan_plataformas');
    }
};
