<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TipoComida;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComidaDiaria extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_nutricional_id',
        'dia_semana',
        'tipo_comida',
        'hora_sugerida',
        'notas',
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
            'plan_nutricional_id' => 'integer',
            'dia_semana' => 'integer',
            'tipo_comida' => TipoComida::class,
        ];
    }

    public function planNutricional(): BelongsTo
    {
        return $this->belongsTo(PlanNutricional::class);
    }

    public function comidaAlimentos(): HasMany
    {
        return $this->hasMany(ComidaAlimento::class);
    }
}
