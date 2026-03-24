<?php

declare(strict_types=1);

namespace App\DTOs\Membresia;

final readonly class UpdateMembresiaPayload
{
    public function __construct(
        public ?int    $socioId = null,
        public ?int    $planId = null,
        public ?int    $planPrecioId = null,
        public ?int    $sedeId = null,
        public ?string $fechaInicio = null,
        public ?string $fechaFin = null,
        public ?int    $clasesRestantes = null,
        public ?string $estado = null,
        public ?string $fechaCongelamiento = null,
        public ?string $fechaDescongelamiento = null,
        public ?int    $diasCongeladosUsados = null,
        public ?int    $vecesCongelado = null,
        public ?bool   $autoRenovar = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'socio_id'                => $this->socioId,
            'plan_id'                 => $this->planId,
            'plan_precio_id'          => $this->planPrecioId,
            'sede_id'                 => $this->sedeId,
            'fecha_inicio'            => $this->fechaInicio,
            'fecha_fin'               => $this->fechaFin,
            'clases_restantes'        => $this->clasesRestantes,
            'estado'                  => $this->estado,
            'fecha_congelamiento'     => $this->fechaCongelamiento,
            'fecha_descongelamiento'  => $this->fechaDescongelamiento,
            'dias_congelados_usados'  => $this->diasCongeladosUsados,
            'veces_congelado'         => $this->vecesCongelado,
            'auto_renovar'            => $this->autoRenovar,
            'notas'                   => $this->notas,
        ], fn ($value) => $value !== null);
    }
}
