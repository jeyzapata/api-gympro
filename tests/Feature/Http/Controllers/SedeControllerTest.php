<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Sede;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SedeController
 */
final class SedeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $sedes = Sede::factory()->count(3)->create();

        $response = $this->get(route('sedes.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SedeController::class,
            'store',
            \App\Http\Requests\Sede\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $nombre = fake()->word();
        $direccion = fake()->word();
        $ciudad = fake()->word();
        $provincia = fake()->word();
        $activa = fake()->boolean();

        $response = $this->post(route('sedes.store'), [
            'nombre' => $nombre,
            'direccion' => $direccion,
            'ciudad' => $ciudad,
            'provincia' => $provincia,
            'activa' => $activa,
        ]);

        $sedes = Sede::query()
            ->where('nombre', $nombre)
            ->where('direccion', $direccion)
            ->where('ciudad', $ciudad)
            ->where('provincia', $provincia)
            ->where('activa', $activa)
            ->get();
        $this->assertCount(1, $sedes);
        $sede = $sedes->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $sede = Sede::factory()->create();

        $response = $this->get(route('sedes.show', $sede));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SedeController::class,
            'update',
            \App\Http\Requests\Sede\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $sede = Sede::factory()->create();
        $nombre = fake()->word();
        $direccion = fake()->word();
        $ciudad = fake()->word();
        $provincia = fake()->word();
        $activa = fake()->boolean();

        $response = $this->put(route('sedes.update', $sede), [
            'nombre' => $nombre,
            'direccion' => $direccion,
            'ciudad' => $ciudad,
            'provincia' => $provincia,
            'activa' => $activa,
        ]);

        $sede->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($nombre, $sede->nombre);
        $this->assertEquals($direccion, $sede->direccion);
        $this->assertEquals($ciudad, $sede->ciudad);
        $this->assertEquals($provincia, $sede->provincia);
        $this->assertEquals($activa, $sede->activa);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $sede = Sede::factory()->create();

        $response = $this->delete(route('sedes.destroy', $sede));

        $response->assertNoContent();

        $this->assertSoftDeleted($sede);
    }
}
