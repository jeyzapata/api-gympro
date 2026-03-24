<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\TipoClase\StoreTipoClasePayload;
use App\DTOs\TipoClase\UpdateTipoClasePayload;
use App\Models\TipoClase;
use App\Repositories\Contracts\TipoClaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class TipoClaseService
{
    public function __construct(
        private readonly TipoClaseRepositoryInterface $tipoClaseRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->tipoClaseRepository->all($perPage);
    }

    public function findOrFail(int $id): TipoClase
    {
        return $this->tipoClaseRepository->findOrFail($id);
    }

    public function create(StoreTipoClasePayload $payload): TipoClase
    {
        return DB::transaction(
            fn () => $this->tipoClaseRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateTipoClasePayload $payload): TipoClase
    {
        return DB::transaction(
            fn () => $this->tipoClaseRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->tipoClaseRepository->delete($id));
    }
}
