<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AplicaPromocion;
use App\Enums\TipoDescuento;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'tipo_descuento',
        'valor',
        'aplica_a',
        'plan_id',
        'sede_id',
        'usos_maximos',
        'usos_actuales',
        'un_uso_por_socio',
        'vigente_desde',
        'vigente_hasta',
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
            'valor' => 'decimal:2',
            'plan_id' => 'integer',
            'sede_id' => 'integer',
            'usos_maximos' => 'integer',
            'usos_actuales' => 'integer',
            'un_uso_por_socio' => 'boolean',
            'vigente_desde' => 'datetime',
            'vigente_hasta' => 'datetime',
            'activa' => 'boolean',
            'tipo_descuento' => TipoDescuento::class,
            'aplica_a' => AplicaPromocion::class,
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

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }
}
