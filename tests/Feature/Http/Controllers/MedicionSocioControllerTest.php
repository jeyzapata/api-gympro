<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\MedicionSocio;
use App\Models\Socio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MedicionSocioController
 */
final class MedicionSocioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $medicionSocios = MedicionSocio::factory()->count(3)->create();

        $response = $this->get(route('medicion-socios.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MedicionSocioController::class,
            'store',
            \App\Http\Requests\MedicionSocio\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $socio = Socio::factory()->create();
        $fecha = Carbon::parse(fake()->date());

        $response = $this->post(route('medicion-socios.store'), [
            'socio_id' => $socio->id,
            'fecha' => $fecha->toDateString(),
        ]);

        $medicionSocios = MedicionSocio::query()
            ->where('socio_id', $socio->id)
            ->where('fecha', $fecha)
            ->get();
        $this->assertCount(1, $medicionSocios);
        $medicionSocio = $medicionSocios->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $medicionSocio = MedicionSocio::factory()->create();

        $response = $this->get(route('medicion-socios.show', $medicionSocio));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MedicionSocioController::class,
            'update',
            \App\Http\Requests\MedicionSocio\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $medicionSocio = MedicionSocio::factory()->create();
        $socio = Socio::factory()->create();
        $fecha = Carbon::parse(fake()->date());

        $response = $this->put(route('medicion-socios.update', $medicionSocio), [
            'socio_id' => $socio->id,
            'fecha' => $fecha->toDateString(),
        ]);

        $medicionSocio->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($socio->id, $medicionSocio->socio_id);
        $this->assertEquals($fecha, $medicionSocio->fecha);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $medicionSocio = MedicionSocio::factory()->create();

        $response = $this->delete(route('medicion-socios.destroy', $medicionSocio));

        $response->assertNoContent();

        $this->assertModelMissing($medicionSocio);
    }
}
