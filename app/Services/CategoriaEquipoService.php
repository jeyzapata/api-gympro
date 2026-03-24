<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CategoriaEquipo\StoreCategoriaEquipoPayload;
use App\DTOs\CategoriaEquipo\UpdateCategoriaEquipoPayload;
use App\Models\CategoriaEquipo;
use App\Repositories\Contracts\CategoriaEquipoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class CategoriaEquipoService
{
    public function __construct(
        private readonly CategoriaEquipoRepositoryInterface $categoriaEquipoRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->categoriaEquipoRepository->all($perPage);
    }

    public function findOrFail(int $id): CategoriaEquipo
    {
        return $this->categoriaEquipoRepository->findOrFail($id);
    }

    public function create(StoreCategoriaEquipoPayload $payload): CategoriaEquipo
    {
        return DB::transaction(
            fn () => $this->categoriaEquipoRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateCategoriaEquipoPayload $payload): CategoriaEquipo
    {
        return DB::transaction(
            fn () => $this->categoriaEquipoRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->categoriaEquipoRepository->delete($id));
    }
}
