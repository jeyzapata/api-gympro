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
        Schema::create('tenants', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 80)->unique();
            $table->string('nombre', 150);
            $table->string('email_admin', 150)->unique();
            $table->string('telefono', 30)->nullable();
            $table->string('logo')->nullable();
            $table->string('schema_name', 80)->unique();
            $table->enum('plan_suscripcion', ["trial","basico","pro","enterprise"])->default('trial');
            $table->timestamp('trial_ends_at')->nullable();
            $table->boolean('suscripcion_activa')->default(true);
            $table->unsignedTinyInteger('max_sedes')->default(1);
            $table->unsignedSmallInteger('max_empleados')->default(10);
            $table->unsignedSmallInteger('max_socios')->default(200);
            $table->json('datos_fiscales')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
