<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicionSocio extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'socio_id',
        'empleado_id',
        'fecha',
        'peso_kg',
        'altura_cm',
        'imc',
        'porcentaje_grasa',
        'masa_muscular_kg',
        'cintura_cm',
        'cadera_cm',
        'pecho_cm',
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
            'empleado_id' => 'integer',
            'fecha' => 'date',
            'peso_kg' => 'decimal:2',
            'altura_cm' => 'decimal:2',
            'imc' => 'decimal:2',
            'porcentaje_grasa' => 'decimal:2',
            'masa_muscular_kg' => 'decimal:2',
            'cintura_cm' => 'decimal:2',
            'cadera_cm' => 'decimal:2',
            'pecho_cm' => 'decimal:2',
        ];
    }

    public function socio(): BelongsTo
    {
        return $this->belongsTo(Socio::class);
    }

    public function empleado(): BelongsTo
    {
        return $this->belongsTo(Empleado::class);
    }
}
