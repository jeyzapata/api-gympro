<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Alimento\StoreAlimentoPayload;
use App\DTOs\Alimento\UpdateAlimentoPayload;
use App\Models\Alimento;
use App\Repositories\Contracts\AlimentoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class AlimentoService
{
    public function __construct(
        private readonly AlimentoRepositoryInterface $alimentoRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->alimentoRepository->all($perPage);
    }

    public function findOrFail(int $id): Alimento
    {
        return $this->alimentoRepository->findOrFail($id);
    }

    public function create(StoreAlimentoPayload $payload): Alimento
    {
        return DB::transaction(
            fn () => $this->alimentoRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateAlimentoPayload $payload): Alimento
    {
        return DB::transaction(
            fn () => $this->alimentoRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->alimentoRepository->delete($id));
    }
}
