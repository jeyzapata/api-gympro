<?php

declare(strict_types=1);

namespace App\Http\Requests\Equipo;

use App\DTOs\Equipo\StoreEquipoPayload;
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
            'sede_id'              => ['required', 'integer', 'exists:sedes,id'],
            'categoria_equipo_id'  => ['required', 'integer', 'exists:categoria_equipos,id'],
            'nombre'               => ['required', 'string', 'max:150'],
            'marca'                => ['nullable', 'string', 'max:80'],
            'modelo'               => ['nullable', 'string', 'max:80'],
            'numero_serie'         => ['nullable', 'string', 'max:100', 'unique:equipos,numero_serie'],
            'fecha_adquisicion'    => ['nullable', 'date'],
            'valor_adquisicion'    => ['nullable', 'numeric', 'min:0'],
            'estado'               => ['sometimes', 'string', 'in:operativo,en_mantenimiento,fuera_de_servicio,dado_de_baja'],
            'ubicacion'            => ['nullable', 'string', 'max:100'],
            'foto'                 => ['nullable', 'string'],
            'notas'                => ['nullable', 'string'],
        ];
    }

    public function payload(): StoreEquipoPayload
    {
        return new StoreEquipoPayload(
            sedeId:            $this->integer('sede_id'),
            categoriaEquipoId: $this->integer('categoria_equipo_id'),
            nombre:            $this->string('nombre')->toString(),
            marca:             $this->string('marca')->toString() ?: null,
            modelo:            $this->string('modelo')->toString() ?: null,
            numeroSerie:       $this->string('numero_serie')->toString() ?: null,
            fechaAdquisicion:  $this->string('fecha_adquisicion')->toString() ?: null,
            valorAdquisicion:  $this->has('valor_adquisicion') ? (float) $this->input('valor_adquisicion') : null,
            estado:            $this->string('estado')->toString() ?: 'operativo',
            ubicacion:         $this->string('ubicacion')->toString() ?: null,
            foto:              $this->string('foto')->toString() ?: null,
            notas:             $this->string('notas')->toString() ?: null,
        );
    }
}
