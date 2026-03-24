<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alimento extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'calorias_por_100g',
        'proteinas_por_100g',
        'carbohidratos_por_100g',
        'grasas_por_100g',
        'fibra_por_100g',
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
            'calorias_por_100g' => 'decimal:2',
            'proteinas_por_100g' => 'decimal:2',
            'carbohidratos_por_100g' => 'decimal:2',
            'grasas_por_100g' => 'decimal:2',
            'fibra_por_100g' => 'decimal:2',
        ];
    }

    public function comidaAlimentos(): HasMany
    {
        return $this->hasMany(ComidaAlimento::class);
    }
}
