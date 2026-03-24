<?php

declare(strict_types=1);

namespace App\Http\Requests\Caja;

use App\DTOs\Caja\UpdateCajaPayload;
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
            'sede_id'               => ['sometimes', 'integer', 'exists:sedes,id'],
            'empleado_id'           => ['sometimes', 'integer', 'exists:empleados,id'],
            'fecha_apertura'        => ['sometimes', 'date'],
            'monto_apertura'        => ['sometimes', 'numeric', 'min:0'],
            'fecha_cierre'          => ['sometimes', 'nullable', 'date'],
            'monto_cierre_real'     => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'monto_cierre_sistema'  => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'diferencia'            => ['sometimes', 'nullable', 'numeric'],
            'estado'                => ['sometimes', 'string', 'in:abierta,cerrada'],
            'observaciones'         => ['sometimes', 'nullable', 'string'],
        ];
    }

    public function payload(): UpdateCajaPayload
    {
        return new UpdateCajaPayload(
            sedeId:             $this->has('sede_id') ? $this->integer('sede_id') : null,
            empleadoId:         $this->has('empleado_id') ? $this->integer('empleado_id') : null,
            fechaApertura:      $this->has('fecha_apertura') ? $this->string('fecha_apertura')->toString() : null,
            montoApertura:      $this->has('monto_apertura') ? (string) $this->input('monto_apertura') : null,
            fechaCierre:        $this->has('fecha_cierre') ? ($this->string('fecha_cierre')->toString() ?: null) : null,
            montoCierreReal:    $this->has('monto_cierre_real') ? ($this->input('monto_cierre_real') !== null ? (string) $this->input('monto_cierre_real') : null) : null,
            montoCierreSistema: $this->has('monto_cierre_sistema') ? ($this->input('monto_cierre_sistema') !== null ? (string) $this->input('monto_cierre_sistema') : null) : null,
            diferencia:         $this->has('diferencia') ? ($this->input('diferencia') !== null ? (string) $this->input('diferencia') : null) : null,
            estado:             $this->has('estado') ? $this->string('estado')->toString() : null,
            observaciones:      $this->has('observaciones') ? ($this->string('observaciones')->toString() ?: null) : null,
        );
    }
}
