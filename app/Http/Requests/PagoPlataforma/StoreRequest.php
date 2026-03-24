<?php

declare(strict_types=1);

namespace App\Http\Requests\PagoPlataforma;

use App\DTOs\PagoPlataforma\StorePagoPlataformaPayload;
use App\Enums\EstadoPagoPlataforma;
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
            'factura_tenant_id' => ['required', 'integer', 'exists:factura_tenants,id'],
            'tenant_id'         => ['required', 'integer', 'exists:tenants,id'],
            'monto'             => ['required', 'numeric', 'min:0'],
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

    public function payload(): StorePagoPlataformaPayload
    {
        return new StorePagoPlataformaPayload(
            facturaTenantId: $this->integer('factura_tenant_id'),
            tenantId:        $this->integer('tenant_id'),
            monto:           $this->string('monto')->toString(),
            moneda:          $this->string('moneda')->toString() ?: 'ARS',
            estado:          $this->string('estado')->toString() ?: 'pendiente',
            mpPreferenceId:  $this->string('mp_preference_id')->toString() ?: null,
            mpPaymentId:     $this->string('mp_payment_id')->toString() ?: null,
            mpStatus:        $this->string('mp_status')->toString() ?: null,
            mpResponse:      $this->input('mp_response'),
            fechaPago:       $this->string('fecha_pago')->toString() ?: null,
            notas:           $this->string('notas')->toString() ?: null,
        );
    }
}
