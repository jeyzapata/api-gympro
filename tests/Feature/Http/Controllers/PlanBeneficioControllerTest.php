<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Plan;
use App\Models\PlanBeneficio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PlanBeneficioController
 */
final class PlanBeneficioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $planBeneficios = PlanBeneficio::factory()->count(3)->create();

        $response = $this->get(route('plan-beneficios.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlanBeneficioController::class,
            'store',
            \App\Http\Requests\PlanBeneficio\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $plan = Plan::factory()->create();
        $descripcion = fake()->word();
        $incluido = fake()->boolean();
        $orden = fake()->randomDigitNotNull();

        $response = $this->post(route('plan-beneficios.store'), [
            'plan_id' => $plan->id,
            'descripcion' => $descripcion,
            'incluido' => $incluido,
            'orden' => $orden,
        ]);

        $planBeneficios = PlanBeneficio::query()
            ->where('plan_id', $plan->id)
            ->where('descripcion', $descripcion)
            ->where('incluido', $incluido)
            ->where('orden', $orden)
            ->get();
        $this->assertCount(1, $planBeneficios);
        $planBeneficio = $planBeneficios->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $planBeneficio = PlanBeneficio::factory()->create();

        $response = $this->get(route('plan-beneficios.show', $planBeneficio));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlanBeneficioController::class,
            'update',
            \App\Http\Requests\PlanBeneficio\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $planBeneficio = PlanBeneficio::factory()->create();
        $plan = Plan::factory()->create();
        $descripcion = fake()->word();
        $incluido = fake()->boolean();
        $orden = fake()->randomDigitNotNull();

        $response = $this->put(route('plan-beneficios.update', $planBeneficio), [
            'plan_id' => $plan->id,
            'descripcion' => $descripcion,
            'incluido' => $incluido,
            'orden' => $orden,
        ]);

        $planBeneficio->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($plan->id, $planBeneficio->plan_id);
        $this->assertEquals($descripcion, $planBeneficio->descripcion);
        $this->assertEquals($incluido, $planBeneficio->incluido);
        $this->assertEquals($orden, $planBeneficio->orden);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $planBeneficio = PlanBeneficio::factory()->create();

        $response = $this->delete(route('plan-beneficios.destroy', $planBeneficio));

        $response->assertNoContent();

        $this->assertModelMissing($planBeneficio);
    }
}
