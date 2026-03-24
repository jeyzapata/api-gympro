<?php

declare(strict_types=1);

namespace App\Http\Requests\FacturaTenant;

use App\DTOs\FacturaTenant\StoreFacturaTenantPayload;
use App\Enums\EstadoFactura;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id'          => ['required', 'integer', 'exists:tenants,id'],
            'plan_plataforma_id' => ['required', 'integer', 'exists:plan_plataformas,id'],
            'numero_factura'     => ['required', 'string', 'max:50', 'unique:factura_tenants,numero_factura'],
            'monto'              => ['required', 'numeric', 'min:0'],
            'moneda'             => ['sometimes', 'string', 'max:3'],
            'periodo_inicio'     => ['required', 'date'],
            'periodo_fin'        => ['required', 'date', 'after_or_equal:periodo_inicio'],
            'fecha_vencimiento'  => ['required', 'date'],
            'estado'             => ['sometimes', Rule::enum(EstadoFactura::class)],
            'fecha_pago'         => ['nullable', 'date'],
            'notas'              => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function payload(): StoreFacturaTenantPayload
    {
        return new StoreFacturaTenantPayload(
            tenantId:         $this->integer('tenant_id'),
            planPlataformaId: $this->integer('plan_plataforma_id'),
            numeroFactura:    $this->string('numero_factura')->toString(),
            monto:            $this->string('monto')->toString(),
            periodoInicio:    $this->string('periodo_inicio')->toString(),
            periodoFin:       $this->string('periodo_fin')->toString(),
            fechaVencimiento: $this->string('fecha_vencimiento')->toString(),
            moneda:           $this->string('moneda')->toString() ?: 'ARS',
            estado:           $this->string('estado')->toString() ?: 'pendiente',
            fechaPago:        $this->string('fecha_pago')->toString() ?: null,
            notas:            $this->string('notas')->toString() ?: null,
        );
    }
}
