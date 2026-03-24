<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Sexo;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Socio extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sede_id',
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
        'fecha_nacimiento',
        'sexo',
        'direccion',
        'foto',
        'numero_socio',
        'referido_por_id',
        'activo',
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
            'fecha_nacimiento' => 'date',
            'referido_por_id' => 'integer',
            'activo' => 'boolean',
            'sexo' => Sexo::class,
        ];
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function referidoPor(): BelongsTo
    {
        return $this->belongsTo(Socio::class, 'referido_por_id');
    }

    public function referidos(): HasMany
    {
        return $this->hasMany(Socio::class, 'referido_por_id');
    }

    public function membresias(): HasMany
    {
        return $this->hasMany(Membresia::class);
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

    public function medicionesSocio(): HasMany
    {
        return $this->hasMany(MedicionSocio::class);
    }

    public function planesNutricionales(): HasMany
    {
        return $this->hasMany(PlanNutricional::class);
    }
}
