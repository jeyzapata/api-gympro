<?php

declare(strict_types=1);

namespace App\Http\Requests\Notificacion;

use App\DTOs\Notificacion\UpdateNotificacionPayload;
use App\Enums\TipoNotificacion;
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
            'user_id'  => ['sometimes', 'integer', 'exists:users,id'],
            'titulo'   => ['sometimes', 'string', 'max:150'],
            'cuerpo'   => ['sometimes', 'string'],
            'tipo'     => ['sometimes', 'string', Rule::enum(TipoNotificacion::class)],
            'leida'    => ['sometimes', 'boolean'],
            'leida_at' => ['sometimes', 'nullable', 'date'],
            'data'     => ['sometimes', 'nullable', 'json'],
        ];
    }

    public function payload(): UpdateNotificacionPayload
    {
        return new UpdateNotificacionPayload(
            userId:  $this->has('user_id') ? $this->integer('user_id') : null,
            titulo:  $this->has('titulo') ? $this->string('titulo')->toString() : null,
            cuerpo:  $this->has('cuerpo') ? $this->string('cuerpo')->toString() : null,
            tipo:    $this->has('tipo') ? $this->string('tipo')->toString() : null,
            leida:   $this->has('leida') ? $this->boolean('leida') : null,
            leidaAt: $this->has('leida_at') ? $this->string('leida_at')->toString() ?: null : null,
            data:    $this->has('data') ? json_decode($this->string('data')->toString(), true) : null,
        );
    }
}
