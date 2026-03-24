<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PlanSuscripcion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\CentralConnection;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasInternalKeys;
use Stancl\Tenancy\Database\TenantCollection;
use Stancl\Tenancy\Events;

class Tenant extends Model implements TenantWithDatabase
{
    use CentralConnection,
        HasDatabase,
        HasDomains,
        HasFactory,
        HasInternalKeys,
        SoftDeletes;

    protected $table = 'tenants';

    /**
     * Map Eloquent model events to stancl/tenancy events
     * so the TenancyServiceProvider pipeline (CreateDatabase, MigrateDatabase, etc.) fires.
     *
     * @var array<string, class-string>
     */
    protected $dispatchesEvents = [
        'creating' => Events\CreatingTenant::class,
        'created'  => Events\TenantCreated::class,
        'saving'   => Events\SavingTenant::class,
        'saved'    => Events\TenantSaved::class,
        'updating' => Events\UpdatingTenant::class,
        'updated'  => Events\TenantUpdated::class,
        'deleting' => Events\DeletingTenant::class,
        'deleted'  => Events\TenantDeleted::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'nombre',
        'email_admin',
        'telefono',
        'logo',
        'schema_name',
        'plan_suscripcion',
        'trial_ends_at',
        'suscripcion_activa',
        'max_sedes',
        'max_empleados',
        'max_socios',
        'datos_fiscales',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'trial_ends_at' => 'timestamp',
            'suscripcion_activa' => 'boolean',
            'max_sedes' => 'integer',
            'max_empleados' => 'integer',
            'max_socios' => 'integer',
            'datos_fiscales' => 'array',
            'plan_suscripcion' => PlanSuscripcion::class,
        ];
    }

    // ─── TenantContract ──────────────────────────────────────────

    public function getTenantKeyName(): string
    {
        return 'id';
    }

    public function getTenantKey(): int
    {
        return (int) $this->getAttribute($this->getTenantKeyName());
    }

    /**
     * Get an internal key.
     *
     * stancl/tenancy stores db_name, db_username, db_password with a prefix.
     * We override getInternal for db_name to return our schema_name field.
     */
    public function getInternal(string $key): mixed
    {
        if ($key === 'db_name') {
            return $this->getAttribute('schema_name');
        }

        return $this->getAttribute(static::internalPrefix() . $key);
    }

    public function setInternal(string $key, $value): static
    {
        if ($key === 'db_name') {
            $this->setAttribute('schema_name', $value);

            return $this;
        }

        $this->setAttribute(static::internalPrefix() . $key, $value);

        return $this;
    }

    /**
     * Run a callback in this tenant's environment.
     */
    public function run(callable $callback): mixed
    {
        $tenancy = tenancy();
        $previousTenant = $tenancy->tenant;

        $tenancy->initialize($this);

        try {
            return $callback($this);
        } finally {
            if ($previousTenant) {
                $tenancy->initialize($previousTenant);
            } else {
                $tenancy->end();
            }
        }
    }

    /**
     * Use auto-incrementing integer IDs, not UUIDs.
     */
    public function getIncrementing(): bool
    {
        return true;
    }

    public function getKeyType(): string
    {
        return 'int';
    }

    public function newCollection(array $models = []): TenantCollection
    {
        return new TenantCollection($models);
    }

    // ─── Relationships ───────────────────────────────────────────

    public function tenantSuscripciones(): HasMany
    {
        return $this->hasMany(TenantSuscripcion::class);
    }

    public function facturaTenants(): HasMany
    {
        return $this->hasMany(FacturaTenant::class);
    }

    public function pagoPlataformas(): HasMany
    {
        return $this->hasMany(PagoPlataforma::class);
    }
}
