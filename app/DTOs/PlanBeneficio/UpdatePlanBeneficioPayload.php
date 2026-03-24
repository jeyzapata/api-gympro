<?php

declare(strict_types=1);

namespace App\DTOs\PlanBeneficio;

final readonly class UpdatePlanBeneficioPayload
{
    public function __construct(
        public ?int    $planId = null,
        public ?string $descripcion = null,
        public ?bool   $incluido = null,
        public ?int    $orden = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'plan_id'     => $this->planId,
            'descripcion' => $this->descripcion,
            'incluido'    => $this->incluido,
            'orden'       => $this->orden,
        ], fn ($value) => $value !== null);
    }
}
