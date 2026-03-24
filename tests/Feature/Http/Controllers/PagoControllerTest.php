<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Empleado;
use App\Models\MetodoPago;
use App\Models\Pago;
use App\Models\Sede;
use App\Models\Socio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PagoController
 */
final class PagoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $pagos = Pago::factory()->count(3)->create();

        $response = $this->get(route('pagos.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PagoController::class,
            'store',
            \App\Http\Requests\Pago\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $socio = Socio::factory()->create();
        $sede = Sede::factory()->create();
        $empleado = Empleado::factory()->create();
        $metodo_pago = MetodoPago::factory()->create();
        $monto_bruto = fake()->randomFloat(/** decimal_attributes **/);
        $monto_descuento = fake()->randomFloat(/** decimal_attributes **/);
        $monto_matricula = fake()->randomFloat(/** decimal_attributes **/);
        $monto_final = fake()->randomFloat(/** decimal_attributes **/);
        $moneda = fake()->word();
        $es_pago_parcial = fake()->boolean();
        $concepto = fake()->word();
        $estado = fake()->randomElement(/** enum_attributes **/);
        $fecha_pago = Carbon::parse(fake()->dateTime());

        $response = $this->post(route('pagos.store'), [
            'socio_id' => $socio->id,
            'sede_id' => $sede->id,
            'empleado_id' => $empleado->id,
            'metodo_pago_id' => $metodo_pago->id,
            'monto_bruto' => $monto_bruto,
            'monto_descuento' => $monto_descuento,
            'monto_matricula' => $monto_matricula,
            'monto_final' => $monto_final,
            'moneda' => $moneda,
            'es_pago_parcial' => $es_pago_parcial,
            'concepto' => $concepto,
            'estado' => $estado,
            'fecha_pago' => $fecha_pago->toDateTimeString(),
        ]);

        $pagos = Pago::query()
            ->where('socio_id', $socio->id)
            ->where('sede_id', $sede->id)
            ->where('empleado_id', $empleado->id)
            ->where('metodo_pago_id', $metodo_pago->id)
            ->where('monto_bruto', $monto_bruto)
            ->where('monto_descuento', $monto_descuento)
            ->where('monto_matricula', $monto_matricula)
            ->where('monto_final', $monto_final)
            ->where('moneda', $moneda)
            ->where('es_pago_parcial', $es_pago_parcial)
            ->where('concepto', $concepto)
            ->where('estado', $estado)
            ->where('fecha_pago', $fecha_pago)
            ->get();
        $this->assertCount(1, $pagos);
        $pago = $pagos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $pago = Pago::factory()->create();

        $response = $this->get(route('pagos.show', $pago));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PagoController::class,
            'update',
            \App\Http\Requests\Pago\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $pago = Pago::factory()->create();
        $socio = Socio::factory()->create();
        $sede = Sede::factory()->create();
        $empleado = Empleado::factory()->create();
        $metodo_pago = MetodoPago::factory()->create();
        $monto_bruto = fake()->randomFloat(/** decimal_attributes **/);
        $monto_descuento = fake()->randomFloat(/** decimal_attributes **/);
        $monto_matricula = fake()->randomFloat(/** decimal_attributes **/);
        $monto_final = fake()->randomFloat(/** decimal_attributes **/);
        $moneda = fake()->word();
        $es_pago_parcial = fake()->boolean();
        $concepto = fake()->word();
        $estado = fake()->randomElement(/** enum_attributes **/);
        $fecha_pago = Carbon::parse(fake()->dateTime());

        $response = $this->put(route('pagos.update', $pago), [
            'socio_id' => $socio->id,
            'sede_id' => $sede->id,
            'empleado_id' => $empleado->id,
            'metodo_pago_id' => $metodo_pago->id,
            'monto_bruto' => $monto_bruto,
            'monto_descuento' => $monto_descuento,
            'monto_matricula' => $monto_matricula,
            'monto_final' => $monto_final,
            'moneda' => $moneda,
            'es_pago_parcial' => $es_pago_parcial,
            'concepto' => $concepto,
            'estado' => $estado,
            'fecha_pago' => $fecha_pago->toDateTimeString(),
        ]);

        $pago->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($socio->id, $pago->socio_id);
        $this->assertEquals($sede->id, $pago->sede_id);
        $this->assertEquals($empleado->id, $pago->empleado_id);
        $this->assertEquals($metodo_pago->id, $pago->metodo_pago_id);
        $this->assertEquals($monto_bruto, $pago->monto_bruto);
        $this->assertEquals($monto_descuento, $pago->monto_descuento);
        $this->assertEquals($monto_matricula, $pago->monto_matricula);
        $this->assertEquals($monto_final, $pago->monto_final);
        $this->assertEquals($moneda, $pago->moneda);
        $this->assertEquals($es_pago_parcial, $pago->es_pago_parcial);
        $this->assertEquals($concepto, $pago->concepto);
        $this->assertEquals($estado, $pago->estado);
        $this->assertEquals($fecha_pago, $pago->fecha_pago);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $pago = Pago::factory()->create();

        $response = $this->delete(route('pagos.destroy', $pago));

        $response->assertNoContent();

        $this->assertModelMissing($pago);
    }
}
