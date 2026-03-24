<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PlanController
 */
final class PlanControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $plans = Plan::factory()->count(3)->create();

        $response = $this->get(route('plans.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlanController::class,
            'store',
            \App\Http\Requests\Plan\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $nombre = fake()->word();
        $tipo = fake()->randomElement(/** enum_attributes **/);
        $permite_congelamiento = fake()->boolean();
        $max_dias_congelamiento = fake()->randomNumber();
        $max_veces_congelamiento = fake()->randomDigitNotNull();
        $permite_acceso_multisede = fake()->boolean();
        $activo = fake()->boolean();
        $orden_display = fake()->randomDigitNotNull();

        $response = $this->post(route('plans.store'), [
            'nombre' => $nombre,
            'tipo' => $tipo,
            'permite_congelamiento' => $permite_congelamiento,
            'max_dias_congelamiento' => $max_dias_congelamiento,
            'max_veces_congelamiento' => $max_veces_congelamiento,
            'permite_acceso_multisede' => $permite_acceso_multisede,
            'activo' => $activo,
            'orden_display' => $orden_display,
        ]);

        $plans = Plan::query()
            ->where('nombre', $nombre)
            ->where('tipo', $tipo)
            ->where('permite_congelamiento', $permite_congelamiento)
            ->where('max_dias_congelamiento', $max_dias_congelamiento)
            ->where('max_veces_congelamiento', $max_veces_congelamiento)
            ->where('permite_acceso_multisede', $permite_acceso_multisede)
            ->where('activo', $activo)
            ->where('orden_display', $orden_display)
            ->get();
        $this->assertCount(1, $plans);
        $plan = $plans->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $plan = Plan::factory()->create();

        $response = $this->get(route('plans.show', $plan));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlanController::class,
            'update',
            \App\Http\Requests\Plan\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $plan = Plan::factory()->create();
        $nombre = fake()->word();
        $tipo = fake()->randomElement(/** enum_attributes **/);
        $permite_congelamiento = fake()->boolean();
        $max_dias_congelamiento = fake()->randomNumber();
        $max_veces_congelamiento = fake()->randomDigitNotNull();
        $permite_acceso_multisede = fake()->boolean();
        $activo = fake()->boolean();
        $orden_display = fake()->randomDigitNotNull();

        $response = $this->put(route('plans.update', $plan), [
            'nombre' => $nombre,
            'tipo' => $tipo,
            'permite_congelamiento' => $permite_congelamiento,
            'max_dias_congelamiento' => $max_dias_congelamiento,
            'max_veces_congelamiento' => $max_veces_congelamiento,
            'permite_acceso_multisede' => $permite_acceso_multisede,
            'activo' => $activo,
            'orden_display' => $orden_display,
        ]);

        $plan->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($nombre, $plan->nombre);
        $this->assertEquals($tipo, $plan->tipo);
        $this->assertEquals($permite_congelamiento, $plan->permite_congelamiento);
        $this->assertEquals($max_dias_congelamiento, $plan->max_dias_congelamiento);
        $this->assertEquals($max_veces_congelamiento, $plan->max_veces_congelamiento);
        $this->assertEquals($permite_acceso_multisede, $plan->permite_acceso_multisede);
        $this->assertEquals($activo, $plan->activo);
        $this->assertEquals($orden_display, $plan->orden_display);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $plan = Plan::factory()->create();

        $response = $this->delete(route('plans.destroy', $plan));

        $response->assertNoContent();

        $this->assertSoftDeleted($plan);
    }
}
