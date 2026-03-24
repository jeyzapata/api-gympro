<?php

declare(strict_types=1);

namespace App\Http\Requests\Equipo;

use App\DTOs\Equipo\UpdateEquipoPayload;
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
            'sede_id'              => ['sometimes', 'integer', 'exists:sedes,id'],
            'categoria_equipo_id'  => ['sometimes', 'integer', 'exists:categoria_equipos,id'],
            'nombre'               => ['sometimes', 'string', 'max:150'],
            'marca'                => ['nullable', 'string', 'max:80'],
            'modelo'               => ['nullable', 'string', 'max:80'],
            'numero_serie'         => ['nullable', 'string', 'max:100', Rule::unique('equipos', 'numero_serie')->ignore($this->route('equipo'))],
            'fecha_adquisicion'    => ['nullable', 'date'],
            'valor_adquisicion'    => ['nullable', 'numeric', 'min:0'],
            'estado'               => ['sometimes', 'string', 'in:operativo,en_mantenimiento,fuera_de_servicio,dado_de_baja'],
            'ubicacion'            => ['nullable', 'string', 'max:100'],
            'foto'                 => ['nullable', 'string'],
            'notas'                => ['nullable', 'string'],
        ];
    }

    public function payload(): UpdateEquipoPayload
    {
        return new UpdateEquipoPayload(
            sedeId:            $this->has('sede_id') ? $this->integer('sede_id') : null,
            categoriaEquipoId: $this->has('categoria_equipo_id') ? $this->integer('categoria_equipo_id') : null,
            nombre:            $this->has('nombre') ? $this->string('nombre')->toString() : null,
            marca:             $this->has('marca') ? $this->string('marca')->toString() ?: null : null,
            modelo:            $this->has('modelo') ? $this->string('modelo')->toString() ?: null : null,
            numeroSerie:       $this->has('numero_serie') ? $this->string('numero_serie')->toString() ?: null : null,
            fechaAdquisicion:  $this->has('fecha_adquisicion') ? $this->string('fecha_adquisicion')->toString() ?: null : null,
            valorAdquisicion:  $this->has('valor_adquisicion') ? (float) $this->input('valor_adquisicion') : null,
            estado:            $this->has('estado') ? $this->string('estado')->toString() : null,
            ubicacion:         $this->has('ubicacion') ? $this->string('ubicacion')->toString() ?: null : null,
            foto:              $this->has('foto') ? $this->string('foto')->toString() ?: null : null,
            notas:             $this->has('notas') ? $this->string('notas')->toString() ?: null : null,
        );
    }
}
