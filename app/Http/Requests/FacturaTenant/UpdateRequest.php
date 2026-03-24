<?php

declare(strict_types=1);

namespace App\Http\Requests\FacturaTenant;

use App\DTOs\FacturaTenant\UpdateFacturaTenantPayload;
use App\Enums\EstadoFactura;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id'          => ['sometimes', 'integer', 'exists:tenants,id'],
            'plan_plataforma_id' => ['sometimes', 'integer', 'exists:plan_plataformas,id'],
            'numero_factura'     => ['sometimes', 'string', 'max:50', Rule::unique('factura_tenants', 'numero_factura')->ignore($this->route('factura'))],
            'monto'              => ['sometimes', 'numeric', 'min:0'],
            'moneda'             => ['sometimes', 'string', 'max:3'],
            'periodo_inicio'     => ['sometimes', 'date'],
            'periodo_fin'        => ['sometimes', 'date', 'after_or_equal:periodo_inicio'],
            'fecha_vencimiento'  => ['sometimes', 'date'],
            'estado'             => ['sometimes', Rule::enum(EstadoFactura::class)],
            'fecha_pago'         => ['nullable', 'date'],
            'notas'              => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function payload(): UpdateFacturaTenantPayload
    {
        return new UpdateFacturaTenantPayload(
            tenantId:         $this->has('tenant_id') ? $this->integer('tenant_id') : null,
            planPlataformaId: $this->has('plan_plataforma_id') ? $this->integer('plan_plataforma_id') : null,
            numeroFactura:    $this->has('numero_factura') ? $this->string('numero_factura')->toString() : null,
            monto:            $this->has('monto') ? $this->string('monto')->toString() : null,
            moneda:           $this->has('moneda') ? $this->string('moneda')->toString() : null,
            periodoInicio:    $this->has('periodo_inicio') ? $this->string('periodo_inicio')->toString() : null,
            periodoFin:       $this->has('periodo_fin') ? $this->string('periodo_fin')->toString() : null,
            fechaVencimiento: $this->has('fecha_vencimiento') ? $this->string('fecha_vencimiento')->toString() : null,
            estado:           $this->has('estado') ? $this->string('estado')->toString() : null,
            fechaPago:        $this->has('fecha_pago') ? $this->string('fecha_pago')->toString() ?: null : null,
            notas:            $this->has('notas') ? $this->string('notas')->toString() ?: null : null,
        );
    }
}
