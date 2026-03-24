<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Promocion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PromocionController
 */
final class PromocionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $promocions = Promocion::factory()->count(3)->create();

        $response = $this->get(route('promocions.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromocionController::class,
            'store',
            \App\Http\Requests\Promocion\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $nombre = fake()->word();
        $tipo_descuento = fake()->randomElement(/** enum_attributes **/);
        $valor = fake()->randomFloat(/** decimal_attributes **/);
        $aplica_a = fake()->randomElement(/** enum_attributes **/);
        $usos_actuales = fake()->randomNumber();
        $un_uso_por_socio = fake()->boolean();
        $vigente_desde = Carbon::parse(fake()->dateTime());
        $activa = fake()->boolean();

        $response = $this->post(route('promocions.store'), [
            'nombre' => $nombre,
            'tipo_descuento' => $tipo_descuento,
            'valor' => $valor,
            'aplica_a' => $aplica_a,
            'usos_actuales' => $usos_actuales,
            'un_uso_por_socio' => $un_uso_por_socio,
            'vigente_desde' => $vigente_desde->toDateTimeString(),
            'activa' => $activa,
        ]);

        $promocions = Promocion::query()
            ->where('nombre', $nombre)
            ->where('tipo_descuento', $tipo_descuento)
            ->where('valor', $valor)
            ->where('aplica_a', $aplica_a)
            ->where('usos_actuales', $usos_actuales)
            ->where('un_uso_por_socio', $un_uso_por_socio)
            ->where('vigente_desde', $vigente_desde)
            ->where('activa', $activa)
            ->get();
        $this->assertCount(1, $promocions);
        $promocion = $promocions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $promocion = Promocion::factory()->create();

        $response = $this->get(route('promocions.show', $promocion));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromocionController::class,
            'update',
            \App\Http\Requests\Promocion\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $promocion = Promocion::factory()->create();
        $nombre = fake()->word();
        $tipo_descuento = fake()->randomElement(/** enum_attributes **/);
        $valor = fake()->randomFloat(/** decimal_attributes **/);
        $aplica_a = fake()->randomElement(/** enum_attributes **/);
        $usos_actuales = fake()->randomNumber();
        $un_uso_por_socio = fake()->boolean();
        $vigente_desde = Carbon::parse(fake()->dateTime());
        $activa = fake()->boolean();

        $response = $this->put(route('promocions.update', $promocion), [
            'nombre' => $nombre,
            'tipo_descuento' => $tipo_descuento,
            'valor' => $valor,
            'aplica_a' => $aplica_a,
            'usos_actuales' => $usos_actuales,
            'un_uso_por_socio' => $un_uso_por_socio,
            'vigente_desde' => $vigente_desde->toDateTimeString(),
            'activa' => $activa,
        ]);

        $promocion->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($nombre, $promocion->nombre);
        $this->assertEquals($tipo_descuento, $promocion->tipo_descuento);
        $this->assertEquals($valor, $promocion->valor);
        $this->assertEquals($aplica_a, $promocion->aplica_a);
        $this->assertEquals($usos_actuales, $promocion->usos_actuales);
        $this->assertEquals($un_uso_por_socio, $promocion->un_uso_por_socio);
        $this->assertEquals($vigente_desde, $promocion->vigente_desde);
        $this->assertEquals($activa, $promocion->activa);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $promocion = Promocion::factory()->create();

        $response = $this->delete(route('promocions.destroy', $promocion));

        $response->assertNoContent();

        $this->assertSoftDeleted($promocion);
    }
}
