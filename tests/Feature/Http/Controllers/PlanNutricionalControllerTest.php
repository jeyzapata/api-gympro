<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Empleado;
use App\Models\PlanNutricional;
use App\Models\Socio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PlanNutricionalController
 */
final class PlanNutricionalControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $planNutricionals = PlanNutricional::factory()->count(3)->create();

        $response = $this->get(route('plan-nutricionals.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlanNutricionalController::class,
            'store',
            \App\Http\Requests\PlanNutricional\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $socio = Socio::factory()->create();
        $empleado = Empleado::factory()->create();
        $nombre = fake()->word();
        $objetivo = fake()->randomElement(/** enum_attributes **/);
        $fecha_inicio = Carbon::parse(fake()->date());
        $activo = fake()->boolean();

        $response = $this->post(route('plan-nutricionals.store'), [
            'socio_id' => $socio->id,
            'empleado_id' => $empleado->id,
            'nombre' => $nombre,
            'objetivo' => $objetivo,
            'fecha_inicio' => $fecha_inicio->toDateString(),
            'activo' => $activo,
        ]);

        $planNutricionals = PlanNutricional::query()
            ->where('socio_id', $socio->id)
            ->where('empleado_id', $empleado->id)
            ->where('nombre', $nombre)
            ->where('objetivo', $objetivo)
            ->where('fecha_inicio', $fecha_inicio)
            ->where('activo', $activo)
            ->get();
        $this->assertCount(1, $planNutricionals);
        $planNutricional = $planNutricionals->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $planNutricional = PlanNutricional::factory()->create();

        $response = $this->get(route('plan-nutricionals.show', $planNutricional));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PlanNutricionalController::class,
            'update',
            \App\Http\Requests\PlanNutricional\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $planNutricional = PlanNutricional::factory()->create();
        $socio = Socio::factory()->create();
        $empleado = Empleado::factory()->create();
        $nombre = fake()->word();
        $objetivo = fake()->randomElement(/** enum_attributes **/);
        $fecha_inicio = Carbon::parse(fake()->date());
        $activo = fake()->boolean();

        $response = $this->put(route('plan-nutricionals.update', $planNutricional), [
            'socio_id' => $socio->id,
            'empleado_id' => $empleado->id,
            'nombre' => $nombre,
            'objetivo' => $objetivo,
            'fecha_inicio' => $fecha_inicio->toDateString(),
            'activo' => $activo,
        ]);

        $planNutricional->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($socio->id, $planNutricional->socio_id);
        $this->assertEquals($empleado->id, $planNutricional->empleado_id);
        $this->assertEquals($nombre, $planNutricional->nombre);
        $this->assertEquals($objetivo, $planNutricional->objetivo);
        $this->assertEquals($fecha_inicio, $planNutricional->fecha_inicio);
        $this->assertEquals($activo, $planNutricional->activo);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $planNutricional = PlanNutricional::factory()->create();

        $response = $this->delete(route('plan-nutricionals.destroy', $planNutricional));

        $response->assertNoContent();

        $this->assertModelMissing($planNutricional);
    }
}
