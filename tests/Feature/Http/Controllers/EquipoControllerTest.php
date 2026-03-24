<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CategoriaEquipo;
use App\Models\Equipo;
use App\Models\Sede;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EquipoController
 */
final class EquipoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $equipos = Equipo::factory()->count(3)->create();

        $response = $this->get(route('equipos.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EquipoController::class,
            'store',
            \App\Http\Requests\Equipo\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $sede = Sede::factory()->create();
        $categoria_equipo = CategoriaEquipo::factory()->create();
        $nombre = fake()->word();
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('equipos.store'), [
            'sede_id' => $sede->id,
            'categoria_equipo_id' => $categoria_equipo->id,
            'nombre' => $nombre,
            'estado' => $estado,
        ]);

        $equipos = Equipo::query()
            ->where('sede_id', $sede->id)
            ->where('categoria_equipo_id', $categoria_equipo->id)
            ->where('nombre', $nombre)
            ->where('estado', $estado)
            ->get();
        $this->assertCount(1, $equipos);
        $equipo = $equipos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->get(route('equipos.show', $equipo));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EquipoController::class,
            'update',
            \App\Http\Requests\Equipo\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $equipo = Equipo::factory()->create();
        $sede = Sede::factory()->create();
        $categoria_equipo = CategoriaEquipo::factory()->create();
        $nombre = fake()->word();
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('equipos.update', $equipo), [
            'sede_id' => $sede->id,
            'categoria_equipo_id' => $categoria_equipo->id,
            'nombre' => $nombre,
            'estado' => $estado,
        ]);

        $equipo->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($sede->id, $equipo->sede_id);
        $this->assertEquals($categoria_equipo->id, $equipo->categoria_equipo_id);
        $this->assertEquals($nombre, $equipo->nombre);
        $this->assertEquals($estado, $equipo->estado);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $equipo = Equipo::factory()->create();

        $response = $this->delete(route('equipos.destroy', $equipo));

        $response->assertNoContent();

        $this->assertSoftDeleted($equipo);
    }
}
