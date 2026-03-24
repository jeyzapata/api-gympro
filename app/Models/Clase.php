<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clase extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sede_id',
        'tipo_clase_id',
        'empleado_id',
        'nombre',
        'descripcion',
        'dia_semana',
        'hora_inicio',
        'hora_fin',
        'capacidad_maxima',
        'es_recurrente',
        'fecha_inicio_vigencia',
        'fecha_fin_vigencia',
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
            'sede_id' => 'integer',
            'tipo_clase_id' => 'integer',
            'empleado_id' => 'integer',
            'dia_semana' => 'integer',
            'capacidad_maxima' => 'integer',
            'es_recurrente' => 'boolean',
            'fecha_inicio_vigencia' => 'date',
            'fecha_fin_vigencia' => 'date',
            'activa' => 'boolean',
        ];
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function tipoClase(): BelongsTo
    {
        return $this->belongsTo(TipoClase::class);
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function turnosClase(): HasMany
    {
        return $this->hasMany(TurnoClase::class);
    }
}
