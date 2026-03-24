<?php

declare(strict_types=1);

namespace App\DTOs\Promocion;

final readonly class UpdatePromocionPayload
{
    public function __construct(
        public ?string $codigo = null,
        public ?string $nombre = null,
        public ?string $descripcion = null,
        public ?string $tipoDescuento = null,
        public ?string $valor = null,
        public ?string $aplicaA = null,
        public ?int    $planId = null,
        public ?int    $sedeId = null,
        public ?int    $usosMaximos = null,
        public ?int    $usosActuales = null,
        public ?bool   $unUsoPorSocio = null,
        public ?string $vigente_desde = null,
        public ?string $vigente_hasta = null,
        public ?bool   $activa = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'codigo'          => $this->codigo,
            'nombre'          => $this->nombre,
            'descripcion'     => $this->descripcion,
            'tipo_descuento'  => $this->tipoDescuento,
            'valor'           => $this->valor,
            'aplica_a'        => $this->aplicaA,
            'plan_id'         => $this->planId,
            'sede_id'         => $this->sedeId,
            'usos_maximos'    => $this->usosMaximos,
            'usos_actuales'   => $this->usosActuales,
            'un_uso_por_socio' => $this->unUsoPorSocio,
            'vigente_desde'   => $this->vigente_desde,
            'vigente_hasta'   => $this->vigente_hasta,
            'activa'          => $this->activa,
        ], fn ($value) => $value !== null);
    }
}
