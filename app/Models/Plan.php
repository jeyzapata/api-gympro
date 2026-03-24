<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'duracion_dias',
        'cantidad_clases',
        'permite_congelamiento',
        'max_dias_congelamiento',
        'max_veces_congelamiento',
        'permite_acceso_multisede',
        'activo',
        'orden_display',
        'color_ui',
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
            'duracion_dias' => 'integer',
            'cantidad_clases' => 'integer',
            'permite_congelamiento' => 'boolean',
            'max_dias_congelamiento' => 'integer',
            'max_veces_congelamiento' => 'integer',
            'permite_acceso_multisede' => 'boolean',
            'activo' => 'boolean',
            'orden_display' => 'integer',
        ];
    }

    public function planPrecios(): HasMany
    {
        return $this->hasMany(PlanPrecio::class);
    }

    public function planBeneficios(): HasMany
    {
        return $this->hasMany(PlanBeneficio::class);
    }

    public function promociones(): HasMany
    {
        return $this->hasMany(Promocion::class);
    }

    public function membresias(): HasMany
    {
        return $this->hasMany(Membresia::class);
    }
}
