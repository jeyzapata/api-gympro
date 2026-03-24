<?php

declare(strict_types=1);

namespace App\DTOs\ComidaAlimento;

final readonly class UpdateComidaAlimentoPayload
{
    public function __construct(
        public ?int   $comidaDiariaId = null,
        public ?int   $alimentoId = null,
        public ?float $cantidadGramos = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'comida_diaria_id' => $this->comidaDiariaId,
            'alimento_id'      => $this->alimentoId,
            'cantidad_gramos'  => $this->cantidadGramos,
        ], fn ($value) => $value !== null);
    }
}
