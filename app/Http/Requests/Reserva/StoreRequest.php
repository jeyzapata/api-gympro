<?php

declare(strict_types=1);

namespace App\Http\Requests\Reserva;

use App\DTOs\Reserva\StoreReservaPayload;
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
            'turno_clase_id'    => ['required', 'integer', 'exists:turno_clases,id'],
            'socio_id'          => ['required', 'integer', 'exists:socios,id'],
            'membresia_id'      => ['nullable', 'integer', 'exists:membresias,id'],
            'estado'            => ['sometimes', 'string', 'in:reservada,confirmada,asistio,ausente,cancelada'],
            'fecha_reserva'     => ['required', 'date'],
            'fecha_cancelacion' => ['nullable', 'date'],
        ];
    }

    public function payload(): StoreReservaPayload
    {
        return new StoreReservaPayload(
            turnoClaseId:    $this->integer('turno_clase_id'),
            socioId:         $this->integer('socio_id'),
            fechaReserva:    $this->string('fecha_reserva')->toString(),
            membresiaId:     $this->has('membresia_id') ? $this->integer('membresia_id') ?: null : null,
            fechaCancelacion: $this->string('fecha_cancelacion')->toString() ?: null,
            estado:          $this->string('estado')->toString() ?: 'reservada',
        );
    }
}
