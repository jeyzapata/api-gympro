<?php

declare(strict_types=1);

namespace App\Http\Requests\Notificacion;

use App\DTOs\Notificacion\StoreNotificacionPayload;
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
            'user_id'  => ['required', 'integer', 'exists:users,id'],
            'titulo'   => ['required', 'string', 'max:150'],
            'cuerpo'   => ['required', 'string'],
            'tipo'     => ['required', 'string', 'in:membresia,pago,clase,mantenimiento,promocion,general'],
            'leida'    => ['sometimes', 'boolean'],
            'leida_at' => ['nullable', 'date'],
            'data'     => ['nullable', 'json'],
        ];
    }

    public function payload(): StoreNotificacionPayload
    {
        return new StoreNotificacionPayload(
            userId:  $this->integer('user_id'),
            titulo:  $this->string('titulo')->toString(),
            cuerpo:  $this->string('cuerpo')->toString(),
            tipo:    $this->string('tipo')->toString(),
            leida:   $this->boolean('leida', false),
            leidaAt: $this->has('leida_at') ? $this->string('leida_at')->toString() ?: null : null,
            data:    $this->has('data') ? json_decode($this->string('data')->toString(), true) : null,
        );
    }
}
