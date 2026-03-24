<?php

declare(strict_types=1);

namespace App\Http\Requests\Tenant;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'max:80', 'unique:tenants,slug'],
            'nombre' => ['required', 'string', 'max:150'],
            'email_admin' => ['required', 'email', 'max:150', 'unique:tenants,email_admin'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'logo' => ['nullable', 'string'],
            'schema_name' => ['required', 'string', 'max:80', 'unique:tenants,schema_name'],
            'plan_suscripcion' => ['required', 'in:trial,basico,pro,enterprise'],
            'trial_ends_at' => ['nullable'],
            'suscripcion_activa' => ['required'],
            'max_sedes' => ['required', 'integer', 'gt:0'],
            'max_empleados' => ['required', 'integer', 'gt:0'],
            'max_socios' => ['required', 'integer', 'gt:0'],
            'datos_fiscales' => ['nullable', 'json'],
        ];
    }
}
