<?php

declare(strict_types=1);

namespace App\DTOs\PlanBeneficio;

final readonly class StorePlanBeneficioPayload
{
    public function __construct(
        public int    $planId,
        public string $descripcion,
        public bool   $incluido = true,
        public int    $orden = 0,
    ) {}

    public function toArray(): array
    {
        return [
            'plan_id'     => $this->planId,
            'descripcion' => $this->descripcion,
            'incluido'    => $this->incluido,
            'orden'       => $this->orden,
        ];
    }
}
