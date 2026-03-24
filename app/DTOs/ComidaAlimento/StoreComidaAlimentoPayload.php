<?php

declare(strict_types=1);

namespace App\DTOs\ComidaAlimento;

final readonly class StoreComidaAlimentoPayload
{
    public function __construct(
        public int   $comidaDiariaId,
        public int   $alimentoId,
        public float $cantidadGramos,
    ) {}

    public function toArray(): array
    {
        return [
            'comida_diaria_id' => $this->comidaDiariaId,
            'alimento_id'      => $this->alimentoId,
            'cantidad_gramos'  => $this->cantidadGramos,
        ];
    }
}
