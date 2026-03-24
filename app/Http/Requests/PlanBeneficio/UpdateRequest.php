<?php

declare(strict_types=1);

namespace App\Http\Requests\PlanBeneficio;

use App\DTOs\PlanBeneficio\UpdatePlanBeneficioPayload;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plan_id'     => ['sometimes', 'integer', 'exists:planes,id'],
            'descripcion' => ['sometimes', 'string', 'min:2', 'max:200'],
            'incluido'    => ['sometimes', 'boolean'],
            'orden'       => ['sometimes', 'integer', 'min:0', 'max:255'],
        ];
    }

    public function payload(): UpdatePlanBeneficioPayload
    {
        return new UpdatePlanBeneficioPayload(
            planId:      $this->has('plan_id') ? $this->integer('plan_id') : null,
            descripcion: $this->has('descripcion') ? $this->string('descripcion')->toString() : null,
            incluido:    $this->has('incluido') ? $this->boolean('incluido') : null,
            orden:       $this->has('orden') ? $this->integer('orden') : null,
        );
    }
}
