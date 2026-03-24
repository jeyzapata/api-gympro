<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EstadoPago;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pago extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'membresia_id',
        'socio_id',
        'sede_id',
        'empleado_id',
        'metodo_pago_id',
        'promocion_id',
        'monto_bruto',
        'monto_descuento',
        'monto_matricula',
        'monto_final',
        'moneda',
        'es_pago_parcial',
        'cuota_numero',
        'cuota_total',
        'concepto',
        'numero_comprobante',
        'referencia_externa',
        'estado',
        'fecha_pago',
        'fecha_vencimiento',
        'anulado_por_id',
        'motivo_anulacion',
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
            'membresia_id' => 'integer',
            'socio_id' => 'integer',
            'sede_id' => 'integer',
            'empleado_id' => 'integer',
            'metodo_pago_id' => 'integer',
            'promocion_id' => 'integer',
            'monto_bruto' => 'decimal:2',
            'monto_descuento' => 'decimal:2',
            'monto_matricula' => 'decimal:2',
            'monto_final' => 'decimal:2',
            'es_pago_parcial' => 'boolean',
            'cuota_numero' => 'integer',
            'cuota_total' => 'integer',
            'fecha_pago' => 'datetime',
            'fecha_vencimiento' => 'date',
            'anulado_por_id' => 'integer',
            'estado' => EstadoPago::class,
        ];
    }

    public function membresia(): BelongsTo
    {
        return $this->belongsTo(Membresia::class);
    }

    public function socio(): BelongsTo
    {
        return $this->belongsTo(Socio::class);
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }

    public function metodoPago(): BelongsTo
    {
        return $this->belongsTo(MetodoPago::class);
    }

    public function promocion(): BelongsTo
    {
        return $this->belongsTo(Promocion::class);
    }

    public function pagoItems(): HasMany
    {
        return $this->hasMany(PagoItem::class);
    }

    public function deudas(): HasMany
    {
        return $this->hasMany(Deuda::class);
    }
}
