<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComidaAlimento extends Model
{
    use BelongsToTenant, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comida_diaria_id',
        'alimento_id',
        'cantidad_gramos',
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
            'comida_diaria_id' => 'integer',
            'alimento_id' => 'integer',
            'cantidad_gramos' => 'decimal:2',
        ];
    }

    public function comidaDiaria(): BelongsTo
    {
        return $this->belongsTo(ComidaDiaria::class);
    }

    public function alimento(): BelongsTo
    {
        return $this->belongsTo(Alimento::class);
    }
}
