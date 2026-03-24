<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TenantController
 */
final class TenantControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $tenants = Tenant::factory()->count(3)->create();

        $response = $this->get(route('tenants.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TenantController::class,
            'store',
            \App\Http\Requests\Tenant\StoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $slug = fake()->slug();
        $nombre = fake()->word();
        $email_admin = fake()->word();
        $schema_name = fake()->word();
        $plan_suscripcion = fake()->randomElement(/** enum_attributes **/);
        $suscripcion_activa = fake()->boolean();
        $max_sedes = fake()->randomDigitNotNull();
        $max_empleados = fake()->randomNumber();
        $max_socios = fake()->randomNumber();

        $response = $this->post(route('tenants.store'), [
            'slug' => $slug,
            'nombre' => $nombre,
            'email_admin' => $email_admin,
            'schema_name' => $schema_name,
            'plan_suscripcion' => $plan_suscripcion,
            'suscripcion_activa' => $suscripcion_activa,
            'max_sedes' => $max_sedes,
            'max_empleados' => $max_empleados,
            'max_socios' => $max_socios,
        ]);

        $tenants = Tenant::query()
            ->where('slug', $slug)
            ->where('nombre', $nombre)
            ->where('email_admin', $email_admin)
            ->where('schema_name', $schema_name)
            ->where('plan_suscripcion', $plan_suscripcion)
            ->where('suscripcion_activa', $suscripcion_activa)
            ->where('max_sedes', $max_sedes)
            ->where('max_empleados', $max_empleados)
            ->where('max_socios', $max_socios)
            ->get();
        $this->assertCount(1, $tenants);
        $tenant = $tenants->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $tenant = Tenant::factory()->create();

        $response = $this->get(route('tenants.show', $tenant));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TenantController::class,
            'update',
            \App\Http\Requests\Tenant\UpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $tenant = Tenant::factory()->create();
        $slug = fake()->slug();
        $nombre = fake()->word();
        $email_admin = fake()->word();
        $schema_name = fake()->word();
        $plan_suscripcion = fake()->randomElement(/** enum_attributes **/);
        $suscripcion_activa = fake()->boolean();
        $max_sedes = fake()->randomDigitNotNull();
        $max_empleados = fake()->randomNumber();
        $max_socios = fake()->randomNumber();

        $response = $this->put(route('tenants.update', $tenant), [
            'slug' => $slug,
            'nombre' => $nombre,
            'email_admin' => $email_admin,
            'schema_name' => $schema_name,
            'plan_suscripcion' => $plan_suscripcion,
            'suscripcion_activa' => $suscripcion_activa,
            'max_sedes' => $max_sedes,
            'max_empleados' => $max_empleados,
            'max_socios' => $max_socios,
        ]);

        $tenant->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($slug, $tenant->slug);
        $this->assertEquals($nombre, $tenant->nombre);
        $this->assertEquals($email_admin, $tenant->email_admin);
        $this->assertEquals($schema_name, $tenant->schema_name);
        $this->assertEquals($plan_suscripcion, $tenant->plan_suscripcion);
        $this->assertEquals($suscripcion_activa, $tenant->suscripcion_activa);
        $this->assertEquals($max_sedes, $tenant->max_sedes);
        $this->assertEquals($max_empleados, $tenant->max_empleados);
        $this->assertEquals($max_socios, $tenant->max_socios);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $tenant = Tenant::factory()->create();

        $response = $this->delete(route('tenants.destroy', $tenant));

        $response->assertNoContent();

        $this->assertSoftDeleted($tenant);
    }
}
