<?php

declare(strict_types=1);

namespace App\DTOs\Membresia;

final readonly class StoreMembresiaPayload
{
    public function __construct(
        public int     $socioId,
        public int     $planId,
        public int     $planPrecioId,
        public int     $sedeId,
        public string  $fechaInicio,
        public ?string $fechaFin = null,
        public ?int    $clasesRestantes = null,
        public string  $estado = 'activa',
        public ?string $fechaCongelamiento = null,
        public ?string $fechaDescongelamiento = null,
        public int     $diasCongeladosUsados = 0,
        public int     $vecesCongelado = 0,
        public bool    $autoRenovar = false,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return [
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
        ];
    }
}
