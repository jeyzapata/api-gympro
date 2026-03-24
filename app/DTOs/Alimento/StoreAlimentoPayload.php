<?php

declare(strict_types=1);

namespace App\DTOs\Alimento;

final readonly class StoreAlimentoPayload
{
    public function __construct(
        public string $nombre,
        public ?float $caloriasPor100g = null,
        public ?float $proteinasPor100g = null,
        public ?float $carbohidratosPor100g = null,
        public ?float $grasasPor100g = null,
        public ?float $fibraPor100g = null,
    ) {}

    public function toArray(): array
    {
        return [
            'nombre'                => $this->nombre,
            'calorias_por_100g'     => $this->caloriasPor100g,
            'proteinas_por_100g'    => $this->proteinasPor100g,
            'carbohidratos_por_100g' => $this->carbohidratosPor100g,
            'grasas_por_100g'       => $this->grasasPor100g,
            'fibra_por_100g'        => $this->fibraPor100g,
        ];
    }
}
