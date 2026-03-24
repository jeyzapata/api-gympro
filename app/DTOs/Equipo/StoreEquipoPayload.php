<?php

declare(strict_types=1);

namespace App\DTOs\Equipo;

final readonly class StoreEquipoPayload
{
    public function __construct(
        public int     $sedeId,
        public int     $categoriaEquipoId,
        public string  $nombre,
        public ?string $marca = null,
        public ?string $modelo = null,
        public ?string $numeroSerie = null,
        public ?string $fechaAdquisicion = null,
        public ?float  $valorAdquisicion = null,
        public string  $estado = 'operativo',
        public ?string $ubicacion = null,
        public ?string $foto = null,
        public ?string $notas = null,
    ) {}

    public function toArray(): array
    {
        return [
            'sede_id'              => $this->sedeId,
            'categoria_equipo_id'  => $this->categoriaEquipoId,
            'nombre'               => $this->nombre,
            'marca'                => $this->marca,
            'modelo'               => $this->modelo,
            'numero_serie'         => $this->numeroSerie,
            'fecha_adquisicion'    => $this->fechaAdquisicion,
            'valor_adquisicion'    => $this->valorAdquisicion,
            'estado'               => $this->estado,
            'ubicacion'            => $this->ubicacion,
            'foto'                 => $this->foto,
            'notas'                => $this->notas,
        ];
    }
}
