<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Clase;
use App\Models\TurnoClase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TurnoClaseController
 */
final class TurnoClaseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $turnoClases = TurnoClase::factory()->count(3)->create();

        $response = $this->get(route('turno-clases.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TurnoClaseController::class,
            'store',
            \App\Http\Requests\TurnoClase\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $clase = Clase::factory()->create();
        $fecha = Carbon::parse(fake()->date());
        $hora_inicio = fake()->time();
        $hora_fin = fake()->time();
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('turno-clases.store'), [
            'clase_id' => $clase->id,
            'fecha' => $fecha->toDateString(),
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'estado' => $estado,
        ]);

        $turnoClases = TurnoClase::query()
            ->where('clase_id', $clase->id)
            ->where('fecha', $fecha)
            ->where('hora_inicio', $hora_inicio)
            ->where('hora_fin', $hora_fin)
            ->where('estado', $estado)
            ->get();
        $this->assertCount(1, $turnoClases);
        $turnoClase = $turnoClases->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $turnoClase = TurnoClase::factory()->create();

        $response = $this->get(route('turno-clases.show', $turnoClase));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TurnoClaseController::class,
            'update',
            \App\Http\Requests\TurnoClase\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $turnoClase = TurnoClase::factory()->create();
        $clase = Clase::factory()->create();
        $fecha = Carbon::parse(fake()->date());
        $hora_inicio = fake()->time();
        $hora_fin = fake()->time();
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('turno-clases.update', $turnoClase), [
            'clase_id' => $clase->id,
            'fecha' => $fecha->toDateString(),
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'estado' => $estado,
        ]);

        $turnoClase->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($clase->id, $turnoClase->clase_id);
        $this->assertEquals($fecha, $turnoClase->fecha);
        $this->assertEquals($hora_inicio, $turnoClase->hora_inicio);
        $this->assertEquals($hora_fin, $turnoClase->hora_fin);
        $this->assertEquals($estado, $turnoClase->estado);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $turnoClase = TurnoClase::factory()->create();

        $response = $this->delete(route('turno-clases.destroy', $turnoClase));

        $response->assertNoContent();

        $this->assertModelMissing($turnoClase);
    }
}
