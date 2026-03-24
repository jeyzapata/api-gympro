<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Empleado;
use App\Models\Plan;
use App\Models\PlanPrecio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PlanPrecioController
 */
final class PlanPrecioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $planPrecios = PlanPrecio::factory()->count(3)->create();

        $response = $this->get(route('plan-precios.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlanPrecioController::class,
            'store',
            \App\Http\Requests\PlanPrecio\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $plan = Plan::factory()->create();
        $precio = fake()->randomFloat(/** decimal_attributes **/);
        $precio_matricula = fake()->randomFloat(/** decimal_attributes **/);
        $moneda = fake()->word();
        $vigente_desde = Carbon::parse(fake()->date());
        $empleado = Empleado::factory()->create();

        $response = $this->post(route('plan-precios.store'), [
            'plan_id' => $plan->id,
            'precio' => $precio,
            'precio_matricula' => $precio_matricula,
            'moneda' => $moneda,
            'vigente_desde' => $vigente_desde->toDateString(),
            'empleado_id' => $empleado->id,
        ]);

        $planPrecios = PlanPrecio::query()
            ->where('plan_id', $plan->id)
            ->where('precio', $precio)
            ->where('precio_matricula', $precio_matricula)
            ->where('moneda', $moneda)
            ->where('vigente_desde', $vigente_desde)
            ->where('empleado_id', $empleado->id)
            ->get();
        $this->assertCount(1, $planPrecios);
        $planPrecio = $planPrecios->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $planPrecio = PlanPrecio::factory()->create();

        $response = $this->get(route('plan-precios.show', $planPrecio));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlanPrecioController::class,
            'update',
            \App\Http\Requests\PlanPrecio\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $planPrecio = PlanPrecio::factory()->create();
        $plan = Plan::factory()->create();
        $precio = fake()->randomFloat(/** decimal_attributes **/);
        $precio_matricula = fake()->randomFloat(/** decimal_attributes **/);
        $moneda = fake()->word();
        $vigente_desde = Carbon::parse(fake()->date());
        $empleado = Empleado::factory()->create();

        $response = $this->put(route('plan-precios.update', $planPrecio), [
            'plan_id' => $plan->id,
            'precio' => $precio,
            'precio_matricula' => $precio_matricula,
            'moneda' => $moneda,
            'vigente_desde' => $vigente_desde->toDateString(),
            'empleado_id' => $empleado->id,
        ]);

        $planPrecio->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($plan->id, $planPrecio->plan_id);
        $this->assertEquals($precio, $planPrecio->precio);
        $this->assertEquals($precio_matricula, $planPrecio->precio_matricula);
        $this->assertEquals($moneda, $planPrecio->moneda);
        $this->assertEquals($vigente_desde, $planPrecio->vigente_desde);
        $this->assertEquals($empleado->id, $planPrecio->empleado_id);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $planPrecio = PlanPrecio::factory()->create();

        $response = $this->delete(route('plan-precios.destroy', $planPrecio));

        $response->assertNoContent();

        $this->assertModelMissing($planPrecio);
    }
}
