<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Equipo\StoreEquipoPayload;
use App\DTOs\Equipo\UpdateEquipoPayload;
use App\Models\Equipo;
use App\Repositories\Contracts\EquipoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class EquipoService
{
    public function __construct(
        private readonly EquipoRepositoryInterface $equipoRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->equipoRepository->all($perPage);
    }

    public function findOrFail(int $id): Equipo
    {
        return $this->equipoRepository->findOrFail($id);
    }

    public function create(StoreEquipoPayload $payload): Equipo
    {
        return DB::transaction(
            fn () => $this->equipoRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateEquipoPayload $payload): Equipo
    {
        return DB::transaction(
            fn () => $this->equipoRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->equipoRepository->delete($id));
    }
}
