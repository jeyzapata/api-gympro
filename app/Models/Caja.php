<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EstadoCaja;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Caja extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sede_id',
        'empleado_id',
        'fecha_apertura',
        'monto_apertura',
        'fecha_cierre',
        'monto_cierre_real',
        'monto_cierre_sistema',
        'diferencia',
        'estado',
        'observaciones',
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
            'empleado_id' => 'integer',
            'fecha_apertura' => 'datetime',
            'monto_apertura' => 'decimal:2',
            'fecha_cierre' => 'datetime',
            'monto_cierre_real' => 'decimal:2',
            'monto_cierre_sistema' => 'decimal:2',
            'diferencia' => 'decimal:2',
            'estado' => EstadoCaja::class,
        ];
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function movimientosCaja(): HasMany
    {
        return $this->hasMany(MovimientoCaja::class);
    }
}
