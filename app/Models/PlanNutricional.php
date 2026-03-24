<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ObjetivoNutricional;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanNutricional extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'socio_id',
        'empleado_id',
        'nombre',
        'objetivo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'activo',
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
            'socio_id' => 'integer',
            'empleado_id' => 'integer',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'activo' => 'boolean',
            'objetivo' => ObjetivoNutricional::class,
        ];
    }

    public function socio(): BelongsTo
    {
        return $this->belongsTo(Socio::class);
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function comidasDiarias(): HasMany
    {
        return $this->hasMany(ComidaDiaria::class);
    }
}
