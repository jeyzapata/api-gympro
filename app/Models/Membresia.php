<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EstadoMembresia;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membresia extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'socio_id',
        'plan_id',
        'plan_precio_id',
        'sede_id',
        'fecha_inicio',
        'fecha_fin',
        'clases_restantes',
        'estado',
        'fecha_congelamiento',
        'fecha_descongelamiento',
        'dias_congelados_usados',
        'veces_congelado',
        'auto_renovar',
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
            'socio_id' => 'integer',
            'plan_id' => 'integer',
            'plan_precio_id' => 'integer',
            'sede_id' => 'integer',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'clases_restantes' => 'integer',
            'fecha_congelamiento' => 'date',
            'fecha_descongelamiento' => 'date',
            'dias_congelados_usados' => 'integer',
            'veces_congelado' => 'integer',
            'auto_renovar' => 'boolean',
            'estado' => EstadoMembresia::class,
        ];
    }

    public function socio(): BelongsTo
    {
        return $this->belongsTo(Socio::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function planPrecio(): BelongsTo
    {
        return $this->belongsTo(PlanPrecio::class);
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    public function deudas(): HasMany
    {
        return $this->hasMany(Deuda::class);
    }

    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class);
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class);
    }
}
