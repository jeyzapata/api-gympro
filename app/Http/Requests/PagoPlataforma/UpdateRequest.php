<?php

declare(strict_types=1);

namespace App\Http\Requests\PagoPlataforma;

use App\DTOs\PagoPlataforma\UpdatePagoPlataformaPayload;
use App\Enums\EstadoPagoPlataforma;
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
            'factura_tenant_id' => ['sometimes', 'integer', 'exists:factura_tenants,id'],
            'tenant_id'         => ['sometimes', 'integer', 'exists:tenants,id'],
            'monto'             => ['sometimes', 'numeric', 'min:0'],
            'moneda'            => ['sometimes', 'string', 'max:3'],
            'estado'            => ['sometimes', Rule::enum(EstadoPagoPlataforma::class)],
            'mp_preference_id'  => ['nullable', 'string', 'max:255'],
            'mp_payment_id'     => ['nullable', 'string', 'max:255'],
            'mp_status'         => ['nullable', 'string', 'max:50'],
            'mp_response'       => ['nullable', 'array'],
            'fecha_pago'        => ['nullable', 'date'],
            'notas'             => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function payload(): UpdatePagoPlataformaPayload
    {
        return new UpdatePagoPlataformaPayload(
            facturaTenantId: $this->has('factura_tenant_id') ? $this->integer('factura_tenant_id') : null,
            tenantId:        $this->has('tenant_id') ? $this->integer('tenant_id') : null,
            monto:           $this->has('monto') ? $this->string('monto')->toString() : null,
            moneda:          $this->has('moneda') ? $this->string('moneda')->toString() : null,
            estado:          $this->has('estado') ? $this->string('estado')->toString() : null,
            mpPreferenceId:  $this->has('mp_preference_id') ? $this->string('mp_preference_id')->toString() ?: null : null,
            mpPaymentId:     $this->has('mp_payment_id') ? $this->string('mp_payment_id')->toString() ?: null : null,
            mpStatus:        $this->has('mp_status') ? $this->string('mp_status')->toString() ?: null : null,
            mpResponse:      $this->has('mp_response') ? $this->input('mp_response') : null,
            fechaPago:       $this->has('fecha_pago') ? $this->string('fecha_pago')->toString() ?: null : null,
            notas:           $this->has('notas') ? $this->string('notas')->toString() ?: null : null,
        );
    }
}
