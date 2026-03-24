<?php

declare(strict_types=1);

namespace App\Http\Requests\PlanBeneficio;

use App\DTOs\PlanBeneficio\StorePlanBeneficioPayload;
use Illuminate\Foundation\Http\FormRequest;

final class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plan_id'     => ['required', 'integer', 'exists:planes,id'],
            'descripcion' => ['required', 'string', 'min:2', 'max:200'],
            'incluido'    => ['sometimes', 'boolean'],
            'orden'       => ['sometimes', 'integer', 'min:0', 'max:255'],
        ];
    }

    public function payload(): StorePlanBeneficioPayload
    {
        return new StorePlanBeneficioPayload(
            planId:      $this->integer('plan_id'),
            descripcion: $this->string('descripcion')->toString(),
            incluido:    $this->boolean('incluido', true),
            orden:       $this->integer('orden', 0),
        );
    }
}
