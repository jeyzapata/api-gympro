<?php

declare(strict_types=1);

namespace App\DTOs\Pago;

final readonly class UpdatePagoPayload
{
    public function __construct(
        public ?int    $socioId = null,
        public ?int    $sedeId = null,
        public ?int    $empleadoId = null,
        public ?int    $metodoPagoId = null,
        public ?int    $membresiaId = null,
        public ?int    $promocionId = null,
        public ?string $montoBruto = null,
        public ?string $montoDescuento = null,
        public ?string $montoMatricula = null,
        public ?string $montoFinal = null,
        public ?string $moneda = null,
        public ?bool   $esPagoParcial = null,
        public ?int    $cuotaNumero = null,
        public ?int    $cuotaTotal = null,
        public ?string $concepto = null,
        public ?string $numeroComprobante = null,
        public ?string $referenciaExterna = null,
        public ?string $estado = null,
        public ?string $fechaPago = null,
        public ?string $fechaVencimiento = null,
        public ?int    $anuladoPorId = null,
        public ?string $motivoAnulacion = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'socio_id'            => $this->socioId,
            'sede_id'             => $this->sedeId,
            'empleado_id'         => $this->empleadoId,
            'metodo_pago_id'      => $this->metodoPagoId,
            'membresia_id'        => $this->membresiaId,
            'promocion_id'        => $this->promocionId,
            'monto_bruto'         => $this->montoBruto,
            'monto_descuento'     => $this->montoDescuento,
            'monto_matricula'     => $this->montoMatricula,
            'monto_final'         => $this->montoFinal,
            'moneda'              => $this->moneda,
            'es_pago_parcial'     => $this->esPagoParcial,
            'cuota_numero'        => $this->cuotaNumero,
            'cuota_total'         => $this->cuotaTotal,
            'concepto'            => $this->concepto,
            'numero_comprobante'  => $this->numeroComprobante,
            'referencia_externa'  => $this->referenciaExterna,
            'estado'              => $this->estado,
            'fecha_pago'          => $this->fechaPago,
            'fecha_vencimiento'   => $this->fechaVencimiento,
            'anulado_por_id'      => $this->anuladoPorId,
            'motivo_anulacion'    => $this->motivoAnulacion,
            'notas'               => $this->notas,
        ], fn ($value) => $value !== null);
    }
}
