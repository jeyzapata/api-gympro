<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Clase;
use App\Models\Empleado;
use App\Models\Sede;
use App\Models\TipoClase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ClaseController
 */
final class ClaseControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $clases = Clase::factory()->count(3)->create();

        $response = $this->get(route('clases.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ClaseController::class,
            'store',
            \App\Http\Requests\Clase\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $sede = Sede::factory()->create();
        $tipo_clase = TipoClase::factory()->create();
        $empleado = Empleado::factory()->create();
        $nombre = fake()->word();
        $hora_inicio = fake()->time();
        $hora_fin = fake()->time();
        $capacidad_maxima = fake()->randomNumber();
        $es_recurrente = fake()->boolean();
        $activa = fake()->boolean();

        $response = $this->post(route('clases.store'), [
            'sede_id' => $sede->id,
            'tipo_clase_id' => $tipo_clase->id,
            'empleado_id' => $empleado->id,
            'nombre' => $nombre,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'capacidad_maxima' => $capacidad_maxima,
            'es_recurrente' => $es_recurrente,
            'activa' => $activa,
        ]);

        $clases = Clase::query()
            ->where('sede_id', $sede->id)
            ->where('tipo_clase_id', $tipo_clase->id)
            ->where('empleado_id', $empleado->id)
            ->where('nombre', $nombre)
            ->where('hora_inicio', $hora_inicio)
            ->where('hora_fin', $hora_fin)
            ->where('capacidad_maxima', $capacidad_maxima)
            ->where('es_recurrente', $es_recurrente)
            ->where('activa', $activa)
            ->get();
        $this->assertCount(1, $clases);
        $clase = $clases->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $clase = Clase::factory()->create();

        $response = $this->get(route('clases.show', $clase));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ClaseController::class,
            'update',
            \App\Http\Requests\Clase\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $clase = Clase::factory()->create();
        $sede = Sede::factory()->create();
        $tipo_clase = TipoClase::factory()->create();
        $empleado = Empleado::factory()->create();
        $nombre = fake()->word();
        $hora_inicio = fake()->time();
        $hora_fin = fake()->time();
        $capacidad_maxima = fake()->randomNumber();
        $es_recurrente = fake()->boolean();
        $activa = fake()->boolean();

        $response = $this->put(route('clases.update', $clase), [
            'sede_id' => $sede->id,
            'tipo_clase_id' => $tipo_clase->id,
            'empleado_id' => $empleado->id,
            'nombre' => $nombre,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'capacidad_maxima' => $capacidad_maxima,
            'es_recurrente' => $es_recurrente,
            'activa' => $activa,
        ]);

        $clase->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($sede->id, $clase->sede_id);
        $this->assertEquals($tipo_clase->id, $clase->tipo_clase_id);
        $this->assertEquals($empleado->id, $clase->empleado_id);
        $this->assertEquals($nombre, $clase->nombre);
        $this->assertEquals($hora_inicio, $clase->hora_inicio);
        $this->assertEquals($hora_fin, $clase->hora_fin);
        $this->assertEquals($capacidad_maxima, $clase->capacidad_maxima);
        $this->assertEquals($es_recurrente, $clase->es_recurrente);
        $this->assertEquals($activa, $clase->activa);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $clase = Clase::factory()->create();

        $response = $this->delete(route('clases.destroy', $clase));

        $response->assertNoContent();

        $this->assertSoftDeleted($clase);
    }
}
