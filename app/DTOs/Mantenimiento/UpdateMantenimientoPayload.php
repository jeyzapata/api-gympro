<?php

declare(strict_types=1);

namespace App\DTOs\Mantenimiento;

final readonly class UpdateMantenimientoPayload
{
    public function __construct(
        public ?int    $equipoId = null,
        public ?int    $empleadoId = null,
        public ?string $tipo = null,
        public ?string $descripcion = null,
        public ?string $fechaProgramada = null,
        public ?string $fechaRealizado = null,
        public ?string $costo = null,
        public ?string $proveedor = null,
        public ?string $estado = null,
        public ?string $proximaRevision = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
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
        ], fn ($value) => $value !== null);
    }
}
