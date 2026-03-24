<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use BelongsToTenant, HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sede_id',
        'rol_id',
        'nombre',
        'apellido',
        'dni',
        'email',
        'telefono',
        'fecha_nacimiento',
        'fecha_ingreso',
        'especialidades',
        'activo',
        'foto',
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
            'rol_id' => 'integer',
            'fecha_nacimiento' => 'date',
            'fecha_ingreso' => 'date',
            'especialidades' => 'array',
            'activo' => 'boolean',
        ];
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class);
    }

    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class);
    }

    public function horariosEmpleado(): HasMany
    {
        return $this->hasMany(HorarioEmpleado::class);
    }

    public function planPrecios(): HasMany
    {
        return $this->hasMany(PlanPrecio::class);
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class);
    }

    public function cajas(): HasMany
    {
        return $this->hasMany(Caja::class);
    }

    public function movimientosCaja(): HasMany
    {
        return $this->hasMany(MovimientoCaja::class);
    }

    public function planesNutricionales(): HasMany
    {
        return $this->hasMany(PlanNutricional::class);
    }

    public function medicionesSocio(): HasMany
    {
        return $this->hasMany(MedicionSocio::class);
    }

    public function mantenimientos(): HasMany
    {
        return $this->hasMany(Mantenimiento::class);
    }

    public function clases(): HasMany
    {
        return $this->hasMany(Clase::class);
    }

    public function turnosClase(): HasMany
    {
        return $this->hasMany(TurnoClase::class, 'instructor_id');
    }
}
