<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Membresia;
use App\Models\Plan;
use App\Models\PlanPrecio;
use App\Models\Sede;
use App\Models\Socio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MembresiaController
 */
final class MembresiaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $membresia = Membresia::factory()->count(3)->create();

        $response = $this->get(route('membresia.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MembresiaController::class,
            'store',
            \App\Http\Requests\Membresia\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $socio = Socio::factory()->create();
        $plan = Plan::factory()->create();
        $plan_precio = PlanPrecio::factory()->create();
        $sede = Sede::factory()->create();
        $fecha_inicio = Carbon::parse(fake()->date());
        $estado = fake()->randomElement(/** enum_attributes **/);
        $dias_congelados_usados = fake()->randomNumber();
        $veces_congelado = fake()->randomDigitNotNull();
        $auto_renovar = fake()->boolean();

        $response = $this->post(route('membresia.store'), [
            'socio_id' => $socio->id,
            'plan_id' => $plan->id,
            'plan_precio_id' => $plan_precio->id,
            'sede_id' => $sede->id,
            'fecha_inicio' => $fecha_inicio->toDateString(),
            'estado' => $estado,
            'dias_congelados_usados' => $dias_congelados_usados,
            'veces_congelado' => $veces_congelado,
            'auto_renovar' => $auto_renovar,
        ]);

        $membresia = Membresia::query()
            ->where('socio_id', $socio->id)
            ->where('plan_id', $plan->id)
            ->where('plan_precio_id', $plan_precio->id)
            ->where('sede_id', $sede->id)
            ->where('fecha_inicio', $fecha_inicio)
            ->where('estado', $estado)
            ->where('dias_congelados_usados', $dias_congelados_usados)
            ->where('veces_congelado', $veces_congelado)
            ->where('auto_renovar', $auto_renovar)
            ->get();
        $this->assertCount(1, $membresia);
        $membresia = $membresia->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $membresia = Membresia::factory()->create();

        $response = $this->get(route('membresia.show', $membresia));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MembresiaController::class,
            'update',
            \App\Http\Requests\Membresia\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $membresia = Membresia::factory()->create();
        $socio = Socio::factory()->create();
        $plan = Plan::factory()->create();
        $plan_precio = PlanPrecio::factory()->create();
        $sede = Sede::factory()->create();
        $fecha_inicio = Carbon::parse(fake()->date());
        $estado = fake()->randomElement(/** enum_attributes **/);
        $dias_congelados_usados = fake()->randomNumber();
        $veces_congelado = fake()->randomDigitNotNull();
        $auto_renovar = fake()->boolean();

        $response = $this->put(route('membresia.update', $membresia), [
            'socio_id' => $socio->id,
            'plan_id' => $plan->id,
            'plan_precio_id' => $plan_precio->id,
            'sede_id' => $sede->id,
            'fecha_inicio' => $fecha_inicio->toDateString(),
            'estado' => $estado,
            'dias_congelados_usados' => $dias_congelados_usados,
            'veces_congelado' => $veces_congelado,
            'auto_renovar' => $auto_renovar,
        ]);

        $membresia->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($socio->id, $membresia->socio_id);
        $this->assertEquals($plan->id, $membresia->plan_id);
        $this->assertEquals($plan_precio->id, $membresia->plan_precio_id);
        $this->assertEquals($sede->id, $membresia->sede_id);
        $this->assertEquals($fecha_inicio, $membresia->fecha_inicio);
        $this->assertEquals($estado, $membresia->estado);
        $this->assertEquals($dias_congelados_usados, $membresia->dias_congelados_usados);
        $this->assertEquals($veces_congelado, $membresia->veces_congelado);
        $this->assertEquals($auto_renovar, $membresia->auto_renovar);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $membresia = Membresia::factory()->create();

        $response = $this->delete(route('membresia.destroy', $membresia));

        $response->assertNoContent();

        $this->assertModelMissing($membresia);
    }
}
