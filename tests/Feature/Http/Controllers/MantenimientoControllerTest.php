<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Equipo;
use App\Models\Mantenimiento;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MantenimientoController
 */
final class MantenimientoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $mantenimientos = Mantenimiento::factory()->count(3)->create();

        $response = $this->get(route('mantenimientos.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MantenimientoController::class,
            'store',
            \App\Http\Requests\Mantenimiento\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $equipo = Equipo::factory()->create();
        $tipo = fake()->randomElement(/** enum_attributes **/);
        $descripcion = fake()->text();
        $fecha_programada = Carbon::parse(fake()->date());
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->post(route('mantenimientos.store'), [
            'equipo_id' => $equipo->id,
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'fecha_programada' => $fecha_programada->toDateString(),
            'estado' => $estado,
        ]);

        $mantenimientos = Mantenimiento::query()
            ->where('equipo_id', $equipo->id)
            ->where('tipo', $tipo)
            ->where('descripcion', $descripcion)
            ->where('fecha_programada', $fecha_programada)
            ->where('estado', $estado)
            ->get();
        $this->assertCount(1, $mantenimientos);
        $mantenimiento = $mantenimientos->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $mantenimiento = Mantenimiento::factory()->create();

        $response = $this->get(route('mantenimientos.show', $mantenimiento));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MantenimientoController::class,
            'update',
            \App\Http\Requests\Mantenimiento\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $mantenimiento = Mantenimiento::factory()->create();
        $equipo = Equipo::factory()->create();
        $tipo = fake()->randomElement(/** enum_attributes **/);
        $descripcion = fake()->text();
        $fecha_programada = Carbon::parse(fake()->date());
        $estado = fake()->randomElement(/** enum_attributes **/);

        $response = $this->put(route('mantenimientos.update', $mantenimiento), [
            'equipo_id' => $equipo->id,
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'fecha_programada' => $fecha_programada->toDateString(),
            'estado' => $estado,
        ]);

        $mantenimiento->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($equipo->id, $mantenimiento->equipo_id);
        $this->assertEquals($tipo, $mantenimiento->tipo);
        $this->assertEquals($descripcion, $mantenimiento->descripcion);
        $this->assertEquals($fecha_programada, $mantenimiento->fecha_programada);
        $this->assertEquals($estado, $mantenimiento->estado);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $mantenimiento = Mantenimiento::factory()->create();

        $response = $this->delete(route('mantenimientos.destroy', $mantenimiento));

        $response->assertNoContent();

        $this->assertModelMissing($mantenimiento);
    }
}
