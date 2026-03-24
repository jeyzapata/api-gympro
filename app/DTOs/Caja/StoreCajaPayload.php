<?php

declare(strict_types=1);

namespace App\DTOs\Caja;

final readonly class StoreCajaPayload
{
    public function __construct(
        public int     $sedeId,
        public int     $empleadoId,
        public string  $fechaApertura,
        public string  $montoApertura = '0',
        public ?string $fechaCierre = null,
        public ?string $montoCierreReal = null,
        public ?string $montoCierreSistema = null,
        public ?string $diferencia = null,
        public string  $estado = 'abierta',
        public ?string $observaciones = null,
    ) {}

    public function toArray(): array
    {
        return [
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
        ];
    }
}
