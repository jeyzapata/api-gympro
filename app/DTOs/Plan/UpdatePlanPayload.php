<?php

declare(strict_types=1);

namespace App\DTOs\Plan;

final readonly class UpdatePlanPayload
{
    public function __construct(
        public ?string $nombre = null,
        public ?string $descripcion = null,
        public ?string $tipo = null,
        public ?int    $duracionDias = null,
        public ?int    $cantidadClases = null,
        public ?bool   $permiteCongelamiento = null,
        public ?int    $maxDiasCongelamiento = null,
        public ?int    $maxVecesCongelamiento = null,
        public ?bool   $permiteAccesoMultisede = null,
        public ?bool   $activo = null,
        public ?int    $ordenDisplay = null,
        public ?string $colorUi = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'nombre'                  => $this->nombre,
            'descripcion'             => $this->descripcion,
            'tipo'                    => $this->tipo,
            'duracion_dias'           => $this->duracionDias,
            'cantidad_clases'         => $this->cantidadClases,
            'permite_congelamiento'   => $this->permiteCongelamiento,
            'max_dias_congelamiento'  => $this->maxDiasCongelamiento,
            'max_veces_congelamiento' => $this->maxVecesCongelamiento,
            'permite_acceso_multisede' => $this->permiteAccesoMultisede,
            'activo'                  => $this->activo,
            'orden_display'           => $this->ordenDisplay,
            'color_ui'                => $this->colorUi,
        ], fn ($value) => $value !== null);
    }
}
