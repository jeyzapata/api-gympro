<?php

declare(strict_types=1);

namespace App\DTOs\MedicionSocio;

final readonly class StoreMedicionSocioPayload
{
    public function __construct(
        public int     $socioId,
        public string  $fecha,
        public ?int    $empleadoId = null,
        public ?float  $pesoKg = null,
        public ?float  $alturaCm = null,
        public ?float  $imc = null,
        public ?float  $porcentajeGrasa = null,
        public ?float  $masaMuscularKg = null,
        public ?float  $cinturaCm = null,
        public ?float  $caderaCm = null,
        public ?float  $pechoCm = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return [
            'socio_id'         => $this->socioId,
            'empleado_id'      => $this->empleadoId,
            'fecha'            => $this->fecha,
            'peso_kg'          => $this->pesoKg,
            'altura_cm'        => $this->alturaCm,
            'imc'              => $this->imc,
            'porcentaje_grasa' => $this->porcentajeGrasa,
            'masa_muscular_kg' => $this->masaMuscularKg,
            'cintura_cm'       => $this->cinturaCm,
            'cadera_cm'        => $this->caderaCm,
            'pecho_cm'         => $this->pechoCm,
            'notas'            => $this->notas,
        ];
    }
}
