<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanPlataforma extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'central';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'slug',
        'precio_mensual',
        'moneda',
        'max_sedes',
        'max_empleados',
        'max_socios',
        'features',
        'activo',
        'orden_display',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'precio_mensual' => 'decimal:2',
            'features' => 'array',
            'activo' => 'boolean',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function facturaTenants(): HasMany
    {
        return $this->hasMany(FacturaTenant::class);
    }

    public function pagoPlataformas(): HasManyThrough
    {
        return $this->hasManyThrough(PagoPlataforma::class, FacturaTenant::class);
    }
}
