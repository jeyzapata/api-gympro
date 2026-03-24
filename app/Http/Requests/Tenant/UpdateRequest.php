<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant;

use App\DTOs\Tenant\UpdateTenantPayload;
use App\Enums\PlanSuscripcion;
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
            'slug'               => ['sometimes', 'string', 'max:80', Rule::unique('tenants', 'slug')->ignore($this->route('tenant'))],
            'nombre'             => ['sometimes', 'string', 'min:2', 'max:120'],
            'email_admin'        => ['sometimes', 'email:rfc,dns', 'max:150'],
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

    public function payload(): UpdateTenantPayload
    {
        return new UpdateTenantPayload(
            slug:              $this->has('slug') ? $this->string('slug')->toString() : null,
            nombre:            $this->has('nombre') ? $this->string('nombre')->toString() : null,
            emailAdmin:        $this->has('email_admin') ? $this->string('email_admin')->toString() : null,
            telefono:          $this->has('telefono') ? $this->string('telefono')->toString() ?: null : null,
            logo:              $this->has('logo') ? $this->string('logo')->toString() ?: null : null,
            planSuscripcion:   $this->has('plan_suscripcion') ? $this->string('plan_suscripcion')->toString() : null,
            suscripcionActiva: $this->has('suscripcion_activa') ? $this->boolean('suscripcion_activa') : null,
            maxSedes:          $this->has('max_sedes') ? $this->integer('max_sedes') : null,
            maxEmpleados:      $this->has('max_empleados') ? $this->integer('max_empleados') : null,
            maxSocios:         $this->has('max_socios') ? $this->integer('max_socios') : null,
            datosFiscales:     $this->has('datos_fiscales') ? $this->input('datos_fiscales') : null,
            trialEndsAt:       $this->has('trial_ends_at') ? $this->string('trial_ends_at')->toString() ?: null : null,
        );
    }
}
