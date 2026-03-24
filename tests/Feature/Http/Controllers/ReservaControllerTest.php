<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Reserva;
use App\Models\Socio;
use App\Models\TurnoClase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReservaController
 */
final class ReservaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $reservas = Reserva::factory()->count(3)->create();

        $response = $this->get(route('reservas.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReservaController::class,
            'store',
            \App\Http\Requests\Reserva\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $turno_clase = TurnoClase::factory()->create();
        $socio = Socio::factory()->create();
        $estado = fake()->randomElement(/** enum_attributes **/);
        $fecha_reserva = Carbon::parse(fake()->dateTime());

        $response = $this->post(route('reservas.store'), [
            'turno_clase_id' => $turno_clase->id,
            'socio_id' => $socio->id,
            'estado' => $estado,
            'fecha_reserva' => $fecha_reserva->toDateTimeString(),
        ]);

        $reservas = Reserva::query()
            ->where('turno_clase_id', $turno_clase->id)
            ->where('socio_id', $socio->id)
            ->where('estado', $estado)
            ->where('fecha_reserva', $fecha_reserva)
            ->get();
        $this->assertCount(1, $reservas);
        $reserva = $reservas->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $reserva = Reserva::factory()->create();

        $response = $this->get(route('reservas.show', $reserva));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ReservaController::class,
            'update',
            \App\Http\Requests\Reserva\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $reserva = Reserva::factory()->create();
        $turno_clase = TurnoClase::factory()->create();
        $socio = Socio::factory()->create();
        $estado = fake()->randomElement(/** enum_attributes **/);
        $fecha_reserva = Carbon::parse(fake()->dateTime());

        $response = $this->put(route('reservas.update', $reserva), [
            'turno_clase_id' => $turno_clase->id,
            'socio_id' => $socio->id,
            'estado' => $estado,
            'fecha_reserva' => $fecha_reserva->toDateTimeString(),
        ]);

        $reserva->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($turno_clase->id, $reserva->turno_clase_id);
        $this->assertEquals($socio->id, $reserva->socio_id);
        $this->assertEquals($estado, $reserva->estado);
        $this->assertEquals($fecha_reserva, $reserva->fecha_reserva);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $reserva = Reserva::factory()->create();

        $response = $this->delete(route('reservas.destroy', $reserva));

        $response->assertNoContent();

        $this->assertModelMissing($reserva);
    }
}
