<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\MedicionSocio;
use App\Repositories\Contracts\MedicionSocioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class MedicionSocioRepository implements MedicionSocioRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return MedicionSocio::with(['socio', 'empleado'])
            ->latest()
            ->paginate($perPage);
    }

    public function findOrFail(int $id): MedicionSocio
    {
        return MedicionSocio::with(['socio', 'empleado'])->findOrFail($id);
    }

    public function create(array $data): MedicionSocio
    {
        return MedicionSocio::create($data);
    }

    public function update(int $id, array $data): MedicionSocio
    {
        $medicionSocio = MedicionSocio::findOrFail($id);
        $medicionSocio->update($data);

        return $medicionSocio->fresh(['socio', 'empleado']);
    }

    public function delete(int $id): void
    {
        MedicionSocio::findOrFail($id)->delete();
    }
}
