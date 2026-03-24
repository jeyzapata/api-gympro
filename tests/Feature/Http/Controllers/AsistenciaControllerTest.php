<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Sede;
use App\Models\Socio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AsistenciaController
 */
final class AsistenciaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $asistencia = Asistencia::factory()->count(3)->create();

        $response = $this->get(route('asistencia.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AsistenciaController::class,
            'store',
            \App\Http\Requests\Asistencia\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $socio = Socio::factory()->create();
        $sede = Sede::factory()->create();
        $fecha_hora_ingreso = Carbon::parse(fake()->dateTime());
        $tipo = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('asistencia.store'), [
            'socio_id' => $socio->id,
            'sede_id' => $sede->id,
            'fecha_hora_ingreso' => $fecha_hora_ingreso->toDateTimeString(),
            'tipo' => $tipo,
        ]);

        $asistencia = Asistencia::query()
            ->where('socio_id', $socio->id)
            ->where('sede_id', $sede->id)
            ->where('fecha_hora_ingreso', $fecha_hora_ingreso)
            ->where('tipo', $tipo)
            ->get();
        $this->assertCount(1, $asistencia);
        $asistencia = $asistencia->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $asistencia = Asistencia::factory()->create();

        $response = $this->get(route('asistencia.show', $asistencia));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AsistenciaController::class,
            'update',
            \App\Http\Requests\Asistencia\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $asistencia = Asistencia::factory()->create();
        $socio = Socio::factory()->create();
        $sede = Sede::factory()->create();
        $fecha_hora_ingreso = Carbon::parse(fake()->dateTime());
        $tipo = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('asistencia.update', $asistencia), [
            'socio_id' => $socio->id,
            'sede_id' => $sede->id,
            'fecha_hora_ingreso' => $fecha_hora_ingreso->toDateTimeString(),
            'tipo' => $tipo,
        ]);

        $asistencia->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($socio->id, $asistencia->socio_id);
        $this->assertEquals($sede->id, $asistencia->sede_id);
        $this->assertEquals($fecha_hora_ingreso, $asistencia->fecha_hora_ingreso);
        $this->assertEquals($tipo, $asistencia->tipo);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $asistencia = Asistencia::factory()->create();

        $response = $this->delete(route('asistencia.destroy', $asistencia));

        $response->assertNoContent();

        $this->assertModelMissing($asistencia);
    }
}
