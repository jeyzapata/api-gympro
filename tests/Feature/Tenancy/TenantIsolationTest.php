<?php

declare(strict_types=1);

namespace Tests\Feature\Tenancy;

use App\Models\Sede;
use App\Models\Socio;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Proves the core security guarantee of GymPro: one gym can never read
 * another gym's data, because each tenant lives in its own PostgreSQL schema.
 *
 * These tests REQUIRE a real PostgreSQL database — SQLite has no schemas,
 * so running them on SQLite would prove nothing.
 *
 * Central migrations must be run against the test database first:
 *
 *   php artisan migrate --env=testing
 *   php artisan test --filter=TenantIsolationTest
 */
final class TenantIsolationTest extends TestCase
{
    private Tenant $gymA;

    private Tenant $gymB;

    protected function setUp(): void
    {
        parent::setUp();

        if (DB::connection('central')->getDriverName() !== 'pgsql') {
            $this->markTestSkipped(
                'Tenant isolation is enforced by PostgreSQL schemas. Point the test database at PostgreSQL to run this.'
            );
        }

        // Creating a Tenant fires TenantCreated, which runs CreateDatabase
        // and MigrateDatabase synchronously (see TenancyServiceProvider).
        $this->gymA = $this->makeTenant('gym-isolation-a', 'gym_isolation_a');
        $this->gymB = $this->makeTenant('gym-isolation-b', 'gym_isolation_b');
    }

    protected function tearDown(): void
    {
        tenancy()->end();

        // Deleting the tenant fires DeleteDatabase, which drops the schema.
        foreach ([$this->gymA ?? null, $this->gymB ?? null] as $tenant) {
            $tenant?->delete();
        }

        parent::tearDown();
    }

    #[Test]
    public function a_socio_created_in_one_tenant_is_invisible_from_the_other(): void
    {
        tenancy()->initialize($this->gymA);

        $sede = Sede::factory()->create();
        Socio::factory()->create([
            'sede_id' => $sede->id,
            'dni' => '30111222',
            'referido_por_id' => null,
        ]);

        $this->assertSame(1, Socio::count(), 'Gym A should see the socio it just created.');

        tenancy()->end();
        tenancy()->initialize($this->gymB);

        $this->assertSame(0, Socio::count(), 'Gym B must not see any socio belonging to gym A.');
        $this->assertNull(
            Socio::where('dni', '30111222')->first(),
            'Gym A data leaked into gym B — tenant isolation is broken.'
        );
    }

    #[Test]
    public function the_search_path_points_at_the_active_tenant_schema(): void
    {
        tenancy()->initialize($this->gymA);
        $this->assertStringContainsString('gym_isolation_a', $this->currentSearchPath());

        tenancy()->end();
        tenancy()->initialize($this->gymB);
        $this->assertStringContainsString('gym_isolation_b', $this->currentSearchPath());
    }

    #[Test]
    public function each_tenant_gets_its_own_schema_in_postgres(): void
    {
        $schemas = DB::connection('central')
            ->table('information_schema.schemata')
            ->whereIn('schema_name', ['gym_isolation_a', 'gym_isolation_b'])
            ->pluck('schema_name')
            ->all();

        sort($schemas);

        $this->assertSame(['gym_isolation_a', 'gym_isolation_b'], $schemas);
    }

    #[Test]
    public function ending_tenancy_leaves_no_tenant_schema_selected(): void
    {
        tenancy()->initialize($this->gymA);
        tenancy()->end();

        $this->assertStringNotContainsString('gym_isolation_a', $this->currentSearchPath());
    }

    private function makeTenant(string $slug, string $schemaName): Tenant
    {
        return Tenant::create([
            'slug' => $slug,
            'nombre' => 'Gimnasio '.$slug,
            'email_admin' => $slug.'@example.test',
            'telefono' => '3804000000',
            'schema_name' => $schemaName,
            'plan_suscripcion' => 'basico',
            'suscripcion_activa' => true,
            'max_sedes' => 1,
            'max_empleados' => 5,
            'max_socios' => 100,
            'datos_fiscales' => [],
        ]);
    }

    private function currentSearchPath(): string
    {
        return (string) DB::connection('pgsql')->select('SHOW search_path')[0]->search_path;
    }
}
