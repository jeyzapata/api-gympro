<?php

declare(strict_types=1);

namespace App\DTOs\Mantenimiento;

final readonly class StoreMantenimientoPayload
{
    public function __construct(
        public int     $equipoId,
        public string  $tipo,
        public string  $descripcion,
        public string  $fechaProgramada,
        public ?int    $empleadoId = null,
        public ?string $fechaRealizado = null,
        public ?string $costo = null,
        public ?string $proveedor = null,
        public string  $estado = 'programado',
        public ?string $proximaRevision = null,
    ) {}

    public function toArray(): array
    {
        return [
            'equipo_id'        => $this->equipoId,
            'empleado_id'      => $this->empleadoId,
            'tipo'             => $this->tipo,
            'descripcion'      => $this->descripcion,
            'fecha_programada' => $this->fechaProgramada,
            'fecha_realizado'  => $this->fechaRealizado,
            'costo'            => $this->costo,
            'proveedor'        => $this->proveedor,
            'estado'           => $this->estado,
            'proxima_revision' => $this->proximaRevision,
        ];
    }
}
