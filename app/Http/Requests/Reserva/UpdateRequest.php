<?php

declare(strict_types=1);

namespace App\Http\Requests\Reserva;

use App\DTOs\Reserva\UpdateReservaPayload;
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
            'turno_clase_id'    => ['sometimes', 'integer', 'exists:turno_clases,id'],
            'socio_id'          => ['sometimes', 'integer', 'exists:socios,id'],
            'membresia_id'      => ['sometimes', 'nullable', 'integer', 'exists:membresias,id'],
            'estado'            => ['sometimes', 'string', 'in:reservada,confirmada,asistio,ausente,cancelada'],
            'fecha_reserva'     => ['sometimes', 'date'],
            'fecha_cancelacion' => ['sometimes', 'nullable', 'date'],
        ];
    }

    public function payload(): UpdateReservaPayload
    {
        return new UpdateReservaPayload(
            turnoClaseId:    $this->has('turno_clase_id') ? $this->integer('turno_clase_id') : null,
            socioId:         $this->has('socio_id') ? $this->integer('socio_id') : null,
            membresiaId:     $this->has('membresia_id') ? ($this->integer('membresia_id') ?: null) : null,
            estado:          $this->has('estado') ? $this->string('estado')->toString() : null,
            fechaReserva:    $this->has('fecha_reserva') ? $this->string('fecha_reserva')->toString() : null,
            fechaCancelacion: $this->has('fecha_cancelacion') ? ($this->string('fecha_cancelacion')->toString() ?: null) : null,
        );
    }
}
