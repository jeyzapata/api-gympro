<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EstadoEquipo;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sede_id',
        'categoria_equipo_id',
        'nombre',
        'marca',
        'modelo',
        'numero_serie',
        'fecha_adquisicion',
        'valor_adquisicion',
        'estado',
        'ubicacion',
        'foto',
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
            'sede_id' => 'integer',
            'categoria_equipo_id' => 'integer',
            'fecha_adquisicion' => 'date',
            'valor_adquisicion' => 'decimal:2',
            'estado' => EstadoEquipo::class,
        ];
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function categoriaEquipo(): BelongsTo
    {
        return $this->belongsTo(CategoriaEquipo::class);
    }

    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class);
    }
}
