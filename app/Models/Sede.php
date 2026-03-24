<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sede extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'provincia',
        'telefono',
        'email',
        'horario_apertura',
        'horario_cierre',
        'activa',
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
            'activa' => 'boolean',
        ];
    }

    public function empleados(): HasMany
    {
        return $this->hasMany(Empleado::class);
    }

    public function socios(): HasMany
    {
        return $this->hasMany(Socio::class);
    }

    public function clases(): HasMany
    {
        return $this->hasMany(Clase::class);
    }

    public function cajas(): HasMany
    {
        return $this->hasMany(Caja::class);
    }

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }

    public function planPrecios(): HasMany
    {
        return $this->hasMany(PlanPrecio::class);
    }

    public function promociones(): HasMany
    {
        return $this->hasMany(Promocion::class);
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    public function deudas(): HasMany
    {
        return $this->hasMany(Deuda::class);
    }
}
