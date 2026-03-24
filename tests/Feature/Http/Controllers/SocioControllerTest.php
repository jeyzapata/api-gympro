<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Sede;
use App\Models\Socio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SocioController
 */
final class SocioControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $socios = Socio::factory()->count(3)->create();

        $response = $this->get(route('socios.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SocioController::class,
            'store',
            \App\Http\Requests\Socio\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $sede = Sede::factory()->create();
        $nombre = fake()->word();
        $apellido = fake()->word();
        $dni = fake()->word();
        $email = fake()->safeEmail();
        $numero_socio = fake()->word();
        $activo = fake()->boolean();

        $response = $this->post(route('socios.store'), [
            'sede_id' => $sede->id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $dni,
            'email' => $email,
            'numero_socio' => $numero_socio,
            'activo' => $activo,
        ]);

        $socios = Socio::query()
            ->where('sede_id', $sede->id)
            ->where('nombre', $nombre)
            ->where('apellido', $apellido)
            ->where('dni', $dni)
            ->where('email', $email)
            ->where('numero_socio', $numero_socio)
            ->where('activo', $activo)
            ->get();
        $this->assertCount(1, $socios);
        $socio = $socios->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $socio = Socio::factory()->create();

        $response = $this->get(route('socios.show', $socio));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SocioController::class,
            'update',
            \App\Http\Requests\Socio\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $socio = Socio::factory()->create();
        $sede = Sede::factory()->create();
        $nombre = fake()->word();
        $apellido = fake()->word();
        $dni = fake()->word();
        $email = fake()->safeEmail();
        $numero_socio = fake()->word();
        $activo = fake()->boolean();

        $response = $this->put(route('socios.update', $socio), [
            'sede_id' => $sede->id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $dni,
            'email' => $email,
            'numero_socio' => $numero_socio,
            'activo' => $activo,
        ]);

        $socio->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($sede->id, $socio->sede_id);
        $this->assertEquals($nombre, $socio->nombre);
        $this->assertEquals($apellido, $socio->apellido);
        $this->assertEquals($dni, $socio->dni);
        $this->assertEquals($email, $socio->email);
        $this->assertEquals($numero_socio, $socio->numero_socio);
        $this->assertEquals($activo, $socio->activo);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $socio = Socio::factory()->create();

        $response = $this->delete(route('socios.destroy', $socio));

        $response->assertNoContent();

        $this->assertSoftDeleted($socio);
    }
}
