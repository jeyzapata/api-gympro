<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EstadoFactura;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FacturaTenant extends Model
{
    use HasFactory;

    protected $connection = 'central';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'plan_plataforma_id',
        'numero_factura',
        'monto',
        'moneda',
        'periodo_inicio',
        'periodo_fin',
        'fecha_vencimiento',
        'estado',
        'fecha_pago',
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
            'monto' => 'decimal:2',
            'estado' => EstadoFactura::class,
            'periodo_inicio' => 'date',
            'periodo_fin' => 'date',
            'fecha_vencimiento' => 'date',
            'fecha_pago' => 'date',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function planPlataforma(): BelongsTo
    {
        return $this->belongsTo(PlanPlataforma::class);
    }

    public function pagoPlataformas(): HasMany
    {
        return $this->hasMany(PagoPlataforma::class);
    }
}
