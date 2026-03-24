<?php

declare(strict_types=1);

namespace App\DTOs\Pago;

final readonly class StorePagoPayload
{
    public function __construct(
        public int     $socioId,
        public int     $sedeId,
        public int     $empleadoId,
        public int     $metodoPagoId,
        public string  $montoBruto,
        public string  $montoFinal,
        public string  $concepto,
        public string  $fechaPago,
        public ?int    $membresiaId = null,
        public ?int    $promocionId = null,
        public string  $montoDescuento = '0',
        public string  $montoMatricula = '0',
        public string  $moneda = 'ARS',
        public bool    $esPagoParcial = false,
        public ?int    $cuotaNumero = null,
        public ?int    $cuotaTotal = null,
        public ?string $numeroComprobante = null,
        public ?string $referenciaExterna = null,
        public string  $estado = 'pagado',
        public ?string $fechaVencimiento = null,
        public ?int    $anuladoPorId = null,
        public ?string $motivoAnulacion = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return [
            'socio_id'            => $this->socioId,
            'sede_id'             => $this->sedeId,
            'empleado_id'         => $this->empleadoId,
            'metodo_pago_id'      => $this->metodoPagoId,
            'monto_bruto'         => $this->montoBruto,
            'monto_final'         => $this->montoFinal,
            'concepto'            => $this->concepto,
            'fecha_pago'          => $this->fechaPago,
            'membresia_id'        => $this->membresiaId,
            'promocion_id'        => $this->promocionId,
            'monto_descuento'     => $this->montoDescuento,
            'monto_matricula'     => $this->montoMatricula,
            'moneda'              => $this->moneda,
            'es_pago_parcial'     => $this->esPagoParcial,
            'cuota_numero'        => $this->cuotaNumero,
            'cuota_total'         => $this->cuotaTotal,
            'numero_comprobante'  => $this->numeroComprobante,
            'referencia_externa'  => $this->referenciaExterna,
            'estado'              => $this->estado,
            'fecha_vencimiento'   => $this->fechaVencimiento,
            'anulado_por_id'      => $this->anuladoPorId,
            'motivo_anulacion'    => $this->motivoAnulacion,
            'notas'               => $this->notas,
        ];
    }
}
