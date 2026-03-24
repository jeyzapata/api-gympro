<?php

declare(strict_types=1);

namespace App\DTOs\Promocion;

final readonly class StorePromocionPayload
{
    public function __construct(
        public string  $nombre,
        public string  $tipoDescuento,
        public string  $valor,
        public string  $aplicaA,
        public string  $vigente_desde,
        public ?string $codigo = null,
        public ?string $descripcion = null,
        public ?int    $planId = null,
        public ?int    $sedeId = null,
        public ?int    $usosMaximos = null,
        public ?string $vigente_hasta = null,
        public int     $usosActuales = 0,
        public bool    $unUsoPorSocio = true,
        public bool    $activa = true,
    ) {}

    public function toArray(): array
    {
        return [
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
        ];
    }
}
