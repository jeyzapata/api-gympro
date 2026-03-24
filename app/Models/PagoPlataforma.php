<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EstadoPagoPlataforma;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PagoPlataforma extends Model
{
    use HasFactory;

    protected $connection = 'central';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'factura_tenant_id',
        'tenant_id',
        'monto',
        'moneda',
        'estado',
        'mp_preference_id',
        'mp_payment_id',
        'mp_status',
        'mp_response',
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
            'estado' => EstadoPagoPlataforma::class,
            'mp_response' => 'array',
            'fecha_pago' => 'datetime',
        ];
    }

    // ─── Relationships ───────────────────────────────────────────

    public function facturaTenant(): BelongsTo
    {
        return $this->belongsTo(FacturaTenant::class);
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
