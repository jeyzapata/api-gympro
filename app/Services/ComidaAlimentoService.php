<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ComidaAlimento\StoreComidaAlimentoPayload;
use App\DTOs\ComidaAlimento\UpdateComidaAlimentoPayload;
use App\Models\ComidaAlimento;
use App\Repositories\Contracts\ComidaAlimentoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class ComidaAlimentoService
{
    public function __construct(
        private readonly ComidaAlimentoRepositoryInterface $comidaAlimentoRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->comidaAlimentoRepository->all($perPage);
    }

    public function findOrFail(int $id): ComidaAlimento
    {
        return $this->comidaAlimentoRepository->findOrFail($id);
    }

    public function create(StoreComidaAlimentoPayload $payload): ComidaAlimento
    {
        return DB::transaction(
            fn () => $this->comidaAlimentoRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateComidaAlimentoPayload $payload): ComidaAlimento
    {
        return DB::transaction(
            fn () => $this->comidaAlimentoRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->comidaAlimentoRepository->delete($id));
    }
}
