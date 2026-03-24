<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Caja;
use App\Models\Empleado;
use App\Models\Sede;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CajaController
 */
final class CajaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $cajas = Caja::factory()->count(3)->create();

        $response = $this->get(route('cajas.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CajaController::class,
            'store',
            \App\Http\Requests\Caja\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $sede = Sede::factory()->create();
        $empleado = Empleado::factory()->create();
        $fecha_apertura = Carbon::parse(fake()->dateTime());
        $monto_apertura = fake()->randomFloat(/** decimal_attributes **/);
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('cajas.store'), [
            'sede_id' => $sede->id,
            'empleado_id' => $empleado->id,
            'fecha_apertura' => $fecha_apertura->toDateTimeString(),
            'monto_apertura' => $monto_apertura,
            'estado' => $estado,
        ]);

        $cajas = Caja::query()
            ->where('sede_id', $sede->id)
            ->where('empleado_id', $empleado->id)
            ->where('fecha_apertura', $fecha_apertura)
            ->where('monto_apertura', $monto_apertura)
            ->where('estado', $estado)
            ->get();
        $this->assertCount(1, $cajas);
        $caja = $cajas->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $caja = Caja::factory()->create();

        $response = $this->get(route('cajas.show', $caja));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CajaController::class,
            'update',
            \App\Http\Requests\Caja\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $caja = Caja::factory()->create();
        $sede = Sede::factory()->create();
        $empleado = Empleado::factory()->create();
        $fecha_apertura = Carbon::parse(fake()->dateTime());
        $monto_apertura = fake()->randomFloat(/** decimal_attributes **/);
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('cajas.update', $caja), [
            'sede_id' => $sede->id,
            'empleado_id' => $empleado->id,
            'fecha_apertura' => $fecha_apertura->toDateTimeString(),
            'monto_apertura' => $monto_apertura,
            'estado' => $estado,
        ]);

        $caja->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($sede->id, $caja->sede_id);
        $this->assertEquals($empleado->id, $caja->empleado_id);
        $this->assertEquals($fecha_apertura, $caja->fecha_apertura);
        $this->assertEquals($monto_apertura, $caja->monto_apertura);
        $this->assertEquals($estado, $caja->estado);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $caja = Caja::factory()->create();

        $response = $this->delete(route('cajas.destroy', $caja));

        $response->assertNoContent();

        $this->assertModelMissing($caja);
    }
}
