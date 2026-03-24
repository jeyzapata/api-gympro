<?php

declare(strict_types=1);

namespace App\Http\Requests\Deuda;

use App\DTOs\Deuda\StoreDeudaPayload;
use App\Enums\EstadoDeuda;
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
            'socio_id'          => ['required', 'integer', 'exists:socios,id'],
            'membresia_id'      => ['nullable', 'integer', 'exists:membresias,id'],
            'sede_id'           => ['required', 'integer', 'exists:sedes,id'],
            'concepto'          => ['required', 'string', 'max:200'],
            'monto'             => ['required', 'numeric', 'min:0'],
            'fecha_generacion'  => ['required', 'date'],
            'fecha_vencimiento' => ['nullable', 'date', 'after_or_equal:fecha_generacion'],
            'estado'            => ['sometimes', 'string', Rule::enum(EstadoDeuda::class)],
            'pago_id'           => ['nullable', 'integer', 'exists:pagos,id'],
        ];
    }

    public function payload(): StoreDeudaPayload
    {
        return new StoreDeudaPayload(
            socioId:          $this->integer('socio_id'),
            sedeId:           $this->integer('sede_id'),
            concepto:         $this->string('concepto')->toString(),
            monto:            $this->string('monto')->toString(),
            fechaGeneracion:  $this->string('fecha_generacion')->toString(),
            membresiaId:      $this->has('membresia_id') ? ($this->integer('membresia_id') ?: null) : null,
            fechaVencimiento: $this->string('fecha_vencimiento')->toString() ?: null,
            pagoId:           $this->has('pago_id') ? ($this->integer('pago_id') ?: null) : null,
            estado:           $this->string('estado')->toString() ?: 'pendiente',
        );
    }
}
