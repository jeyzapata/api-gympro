<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant;

use App\DTOs\Tenant\StoreTenantPayload;
use App\Enums\PlanSuscripcion;
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
            'slug'               => ['required', 'string', 'max:80', 'unique:tenants,slug'],
            'nombre'             => ['required', 'string', 'min:2', 'max:120'],
            'email_admin'        => ['required', 'email:rfc,dns', 'max:150'],
            'schema_name'        => ['required', 'string', 'max:80', 'unique:tenants,schema_name'],
            'telefono'           => ['nullable', 'string', 'max:30'],
            'logo'               => ['nullable', 'string', 'max:255'],
            'plan_suscripcion'   => ['sometimes', Rule::enum(PlanSuscripcion::class)],
            'suscripcion_activa' => ['sometimes', 'boolean'],
            'max_sedes'          => ['sometimes', 'integer', 'min:1'],
            'max_empleados'      => ['sometimes', 'integer', 'min:1'],
            'max_socios'         => ['sometimes', 'integer', 'min:1'],
            'datos_fiscales'     => ['nullable', 'array'],
            'trial_ends_at'      => ['nullable', 'date'],
        ];
    }

    public function payload(): StoreTenantPayload
    {
        return new StoreTenantPayload(
            slug:              $this->string('slug')->toString(),
            nombre:            $this->string('nombre')->toString(),
            emailAdmin:        $this->string('email_admin')->toString(),
            schemaName:        $this->string('schema_name')->toString(),
            telefono:          $this->string('telefono')->toString() ?: null,
            logo:              $this->string('logo')->toString() ?: null,
            planSuscripcion:   $this->string('plan_suscripcion')->toString() ?: 'basico',
            suscripcionActiva: $this->boolean('suscripcion_activa', true),
            maxSedes:          $this->integer('max_sedes', 1),
            maxEmpleados:      $this->integer('max_empleados', 10),
            maxSocios:         $this->integer('max_socios', 200),
            datosFiscales:     $this->input('datos_fiscales'),
            trialEndsAt:       $this->string('trial_ends_at')->toString() ?: null,
        );
    }
}
