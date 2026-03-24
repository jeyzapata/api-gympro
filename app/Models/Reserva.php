<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EstadoReserva;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reserva extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'turno_clase_id',
        'socio_id',
        'membresia_id',
        'estado',
        'fecha_reserva',
        'fecha_cancelacion',
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
            'turno_clase_id' => 'integer',
            'socio_id' => 'integer',
            'membresia_id' => 'integer',
            'fecha_reserva' => 'datetime',
            'fecha_cancelacion' => 'datetime',
            'estado' => EstadoReserva::class,
        ];
    }

    public function turnoClase(): BelongsTo
    {
        return $this->belongsTo(TurnoClase::class);
    }

    public function socio(): BelongsTo
    {
        return $this->belongsTo(Socio::class);
    }

    public function membresia(): BelongsTo
    {
        return $this->belongsTo(Membresia::class);
    }
}
