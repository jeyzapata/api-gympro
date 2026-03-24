<?php

declare(strict_types=1);

namespace App\Http\Requests\Caja;

use App\DTOs\Caja\StoreCajaPayload;
use App\Enums\EstadoCaja;
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
            'sede_id'               => ['required', 'integer', 'exists:sedes,id'],
            'empleado_id'           => ['required', 'integer', 'exists:empleados,id'],
            'fecha_apertura'        => ['required', 'date'],
            'monto_apertura'        => ['sometimes', 'numeric', 'min:0'],
            'fecha_cierre'          => ['nullable', 'date', 'after:fecha_apertura'],
            'monto_cierre_real'     => ['nullable', 'numeric', 'min:0'],
            'monto_cierre_sistema'  => ['nullable', 'numeric', 'min:0'],
            'diferencia'            => ['nullable', 'numeric'],
            'estado'                => ['sometimes', 'string', Rule::enum(EstadoCaja::class)],
            'observaciones'         => ['nullable', 'string'],
        ];
    }

    public function payload(): StoreCajaPayload
    {
        return new StoreCajaPayload(
            sedeId:             $this->integer('sede_id'),
            empleadoId:         $this->integer('empleado_id'),
            fechaApertura:      $this->string('fecha_apertura')->toString(),
            montoApertura:      $this->has('monto_apertura') ? (string) $this->input('monto_apertura') : '0',
            fechaCierre:        $this->string('fecha_cierre')->toString() ?: null,
            montoCierreReal:    $this->has('monto_cierre_real') ? (string) $this->input('monto_cierre_real') : null,
            montoCierreSistema: $this->has('monto_cierre_sistema') ? (string) $this->input('monto_cierre_sistema') : null,
            diferencia:         $this->has('diferencia') ? (string) $this->input('diferencia') : null,
            estado:             $this->string('estado')->toString() ?: 'abierta',
            observaciones:      $this->string('observaciones')->toString() ?: null,
        );
    }
}
