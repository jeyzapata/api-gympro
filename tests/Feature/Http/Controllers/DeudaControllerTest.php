<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Deuda;
use App\Models\Sede;
use App\Models\Socio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DeudaController
 */
final class DeudaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $deudas = Deuda::factory()->count(3)->create();

        $response = $this->get(route('deudas.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeudaController::class,
            'store',
            \App\Http\Requests\Deuda\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $socio = Socio::factory()->create();
        $sede = Sede::factory()->create();
        $concepto = fake()->word();
        $monto = fake()->randomFloat(/** decimal_attributes **/);
        $fecha_generacion = Carbon::parse(fake()->date());
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('deudas.store'), [
            'socio_id' => $socio->id,
            'sede_id' => $sede->id,
            'concepto' => $concepto,
            'monto' => $monto,
            'fecha_generacion' => $fecha_generacion->toDateString(),
            'estado' => $estado,
        ]);

        $deudas = Deuda::query()
            ->where('socio_id', $socio->id)
            ->where('sede_id', $sede->id)
            ->where('concepto', $concepto)
            ->where('monto', $monto)
            ->where('fecha_generacion', $fecha_generacion)
            ->where('estado', $estado)
            ->get();
        $this->assertCount(1, $deudas);
        $deuda = $deudas->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $deuda = Deuda::factory()->create();

        $response = $this->get(route('deudas.show', $deuda));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DeudaController::class,
            'update',
            \App\Http\Requests\Deuda\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $deuda = Deuda::factory()->create();
        $socio = Socio::factory()->create();
        $sede = Sede::factory()->create();
        $concepto = fake()->word();
        $monto = fake()->randomFloat(/** decimal_attributes **/);
        $fecha_generacion = Carbon::parse(fake()->date());
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('deudas.update', $deuda), [
            'socio_id' => $socio->id,
            'sede_id' => $sede->id,
            'concepto' => $concepto,
            'monto' => $monto,
            'fecha_generacion' => $fecha_generacion->toDateString(),
            'estado' => $estado,
        ]);

        $deuda->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($socio->id, $deuda->socio_id);
        $this->assertEquals($sede->id, $deuda->sede_id);
        $this->assertEquals($concepto, $deuda->concepto);
        $this->assertEquals($monto, $deuda->monto);
        $this->assertEquals($fecha_generacion, $deuda->fecha_generacion);
        $this->assertEquals($estado, $deuda->estado);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $deuda = Deuda::factory()->create();

        $response = $this->delete(route('deudas.destroy', $deuda));

        $response->assertNoContent();

        $this->assertModelMissing($deuda);
    }
}
