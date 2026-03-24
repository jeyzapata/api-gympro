<?php

declare(strict_types=1);

namespace App\DTOs\ComidaDiaria;

final readonly class StoreComidaDiariaPayload
{
    public function __construct(
        public int     $planNutricionalId,
        public int     $diaSemana,
        public string  $tipoComida,
        public ?string $horaSugerida = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return [
            'plan_nutricional_id' => $this->planNutricionalId,
            'dia_semana'          => $this->diaSemana,
            'tipo_comida'         => $this->tipoComida,
            'hora_sugerida'       => $this->horaSugerida,
            'notas'               => $this->notas,
        ];
    }
}
