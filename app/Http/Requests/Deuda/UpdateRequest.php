<?php

declare(strict_types=1);

namespace App\Http\Requests\Deuda;

use App\DTOs\Deuda\UpdateDeudaPayload;
use App\Enums\EstadoDeuda;
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
            'socio_id'          => ['sometimes', 'integer', 'exists:socios,id'],
            'membresia_id'      => ['sometimes', 'nullable', 'integer', 'exists:membresias,id'],
            'sede_id'           => ['sometimes', 'integer', 'exists:sedes,id'],
            'concepto'          => ['sometimes', 'string', 'max:200'],
            'monto'             => ['sometimes', 'numeric', 'min:0'],
            'fecha_generacion'  => ['sometimes', 'date'],
            'fecha_vencimiento' => ['sometimes', 'nullable', 'date'],
            'estado'            => ['sometimes', 'string', Rule::enum(EstadoDeuda::class)],
            'pago_id'           => ['sometimes', 'nullable', 'integer', 'exists:pagos,id'],
        ];
    }

    public function payload(): UpdateDeudaPayload
    {
        return new UpdateDeudaPayload(
            socioId:          $this->has('socio_id') ? $this->integer('socio_id') : null,
            sedeId:           $this->has('sede_id') ? $this->integer('sede_id') : null,
            concepto:         $this->has('concepto') ? $this->string('concepto')->toString() : null,
            monto:            $this->has('monto') ? $this->string('monto')->toString() : null,
            fechaGeneracion:  $this->has('fecha_generacion') ? $this->string('fecha_generacion')->toString() : null,
            membresiaId:      $this->has('membresia_id') ? ($this->integer('membresia_id') ?: null) : null,
            fechaVencimiento: $this->has('fecha_vencimiento') ? ($this->string('fecha_vencimiento')->toString() ?: null) : null,
            pagoId:           $this->has('pago_id') ? ($this->integer('pago_id') ?: null) : null,
            estado:           $this->has('estado') ? $this->string('estado')->toString() : null,
        );
    }
}
