<?php

declare(strict_types=1);

namespace App\DTOs\ComidaDiaria;

final readonly class UpdateComidaDiariaPayload
{
    public function __construct(
        public ?int    $planNutricionalId = null,
        public ?int    $diaSemana = null,
        public ?string $tipoComida = null,
        public ?string $horaSugerida = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'plan_nutricional_id' => $this->planNutricionalId,
            'dia_semana'          => $this->diaSemana,
            'tipo_comida'         => $this->tipoComida,
            'hora_sugerida'       => $this->horaSugerida,
            'notas'               => $this->notas,
        ], fn ($value) => $value !== null);
    }
}
