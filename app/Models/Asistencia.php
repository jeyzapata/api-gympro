<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TipoAsistencia;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'socio_id',
        'sede_id',
        'turno_clase_id',
        'membresia_id',
        'fecha_hora_ingreso',
        'fecha_hora_egreso',
        'tipo',
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
            'sede_id' => 'integer',
            'turno_clase_id' => 'integer',
            'membresia_id' => 'integer',
            'fecha_hora_ingreso' => 'datetime',
            'fecha_hora_egreso' => 'datetime',
            'tipo' => TipoAsistencia::class,
        ];
    }

    public function socio(): BelongsTo
    {
        return $this->belongsTo(Socio::class);
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function turnoClase(): BelongsTo
    {
        return $this->belongsTo(TurnoClase::class);
    }

    public function membresia(): BelongsTo
    {
        return $this->belongsTo(Membresia::class);
    }
}
