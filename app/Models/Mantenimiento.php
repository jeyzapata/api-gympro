<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EstadoMantenimiento;
use App\Enums\TipoMantenimiento;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mantenimiento extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'equipo_id',
        'empleado_id',
        'tipo',
        'descripcion',
        'fecha_programada',
        'fecha_realizado',
        'costo',
        'proveedor',
        'estado',
        'proxima_revision',
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
            'equipo_id' => 'integer',
            'empleado_id' => 'integer',
            'fecha_programada' => 'date',
            'fecha_realizado' => 'date',
            'costo' => 'decimal:2',
            'proxima_revision' => 'date',
            'tipo' => TipoMantenimiento::class,
            'estado' => EstadoMantenimiento::class,
        ];
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }
}
