<?php

declare(strict_types=1);

namespace App\DTOs\Caja;

final readonly class UpdateCajaPayload
{
    public function __construct(
        public ?int    $sedeId = null,
        public ?int    $empleadoId = null,
        public ?string $fechaApertura = null,
        public ?string $montoApertura = null,
        public ?string $fechaCierre = null,
        public ?string $montoCierreReal = null,
        public ?string $montoCierreSistema = null,
        public ?string $diferencia = null,
        public ?string $estado = null,
        public ?string $observaciones = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'sede_id'               => $this->sedeId,
            'empleado_id'           => $this->empleadoId,
            'fecha_apertura'        => $this->fechaApertura,
            'monto_apertura'        => $this->montoApertura,
            'fecha_cierre'          => $this->fechaCierre,
            'monto_cierre_real'     => $this->montoCierreReal,
            'monto_cierre_sistema'  => $this->montoCierreSistema,
            'diferencia'            => $this->diferencia,
            'estado'                => $this->estado,
            'observaciones'         => $this->observaciones,
        ], fn ($value) => $value !== null);
    }
}
