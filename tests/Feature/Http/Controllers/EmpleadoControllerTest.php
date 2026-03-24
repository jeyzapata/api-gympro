<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Empleado;
use App\Models\Rol;
use App\Models\Sede;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmpleadoController
 */
final class EmpleadoControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $empleados = Empleado::factory()->count(3)->create();

        $response = $this->get(route('empleados.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmpleadoController::class,
            'store',
            \App\Http\Requests\Empleado\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $sede = Sede::factory()->create();
        $rol = Rol::factory()->create();
        $nombre = fake()->word();
        $apellido = fake()->word();
        $dni = fake()->word();
        $email = fake()->safeEmail();
        $fecha_ingreso = Carbon::parse(fake()->date());
        $activo = fake()->boolean();

        $response = $this->post(route('empleados.store'), [
            'sede_id' => $sede->id,
            'rol_id' => $rol->id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $dni,
            'email' => $email,
            'fecha_ingreso' => $fecha_ingreso->toDateString(),
            'activo' => $activo,
        ]);

        $empleados = Empleado::query()
            ->where('sede_id', $sede->id)
            ->where('rol_id', $rol->id)
            ->where('nombre', $nombre)
            ->where('apellido', $apellido)
            ->where('dni', $dni)
            ->where('email', $email)
            ->where('fecha_ingreso', $fecha_ingreso)
            ->where('activo', $activo)
            ->get();
        $this->assertCount(1, $empleados);
        $empleado = $empleados->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $empleado = Empleado::factory()->create();

        $response = $this->get(route('empleados.show', $empleado));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmpleadoController::class,
            'update',
            \App\Http\Requests\Empleado\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $empleado = Empleado::factory()->create();
        $sede = Sede::factory()->create();
        $rol = Rol::factory()->create();
        $nombre = fake()->word();
        $apellido = fake()->word();
        $dni = fake()->word();
        $email = fake()->safeEmail();
        $fecha_ingreso = Carbon::parse(fake()->date());
        $activo = fake()->boolean();

        $response = $this->put(route('empleados.update', $empleado), [
            'sede_id' => $sede->id,
            'rol_id' => $rol->id,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'dni' => $dni,
            'email' => $email,
            'fecha_ingreso' => $fecha_ingreso->toDateString(),
            'activo' => $activo,
        ]);

        $empleado->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($sede->id, $empleado->sede_id);
        $this->assertEquals($rol->id, $empleado->rol_id);
        $this->assertEquals($nombre, $empleado->nombre);
        $this->assertEquals($apellido, $empleado->apellido);
        $this->assertEquals($dni, $empleado->dni);
        $this->assertEquals($email, $empleado->email);
        $this->assertEquals($fecha_ingreso, $empleado->fecha_ingreso);
        $this->assertEquals($activo, $empleado->activo);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $empleado = Empleado::factory()->create();

        $response = $this->delete(route('empleados.destroy', $empleado));

        $response->assertNoContent();

        $this->assertSoftDeleted($empleado);
    }
}
