<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanPrecio extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id',
        'sede_id',
        'precio',
        'precio_matricula',
        'moneda',
        'vigente_desde',
        'vigente_hasta',
        'motivo_cambio',
        'empleado_id',
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
            'plan_id' => 'integer',
            'sede_id' => 'integer',
            'precio' => 'decimal:2',
            'precio_matricula' => 'decimal:2',
            'vigente_desde' => 'date',
            'vigente_hasta' => 'date',
            'empleado_id' => 'integer',
        ];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function membresias(): HasMany
    {
        return $this->hasMany(Membresia::class);
    }
}
