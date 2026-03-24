<?php

declare(strict_types=1);

namespace App\DTOs\Plan;

final readonly class StorePlanPayload
{
    public function __construct(
        public string  $nombre,
        public string  $tipo,
        public ?string $descripcion = null,
        public ?int    $duracionDias = null,
        public ?int    $cantidadClases = null,
        public bool    $permiteCongelamiento = false,
        public int     $maxDiasCongelamiento = 0,
        public int     $maxVecesCongelamiento = 0,
        public bool    $permiteAccesoMultisede = false,
        public bool    $activo = true,
        public int     $ordenDisplay = 0,
        public ?string $colorUi = null,
    ) {}

    public function toArray(): array
    {
        return [
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
        ];
    }
}
