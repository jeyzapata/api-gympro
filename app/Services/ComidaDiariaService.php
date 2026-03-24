<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ComidaDiaria\StoreComidaDiariaPayload;
use App\DTOs\ComidaDiaria\UpdateComidaDiariaPayload;
use App\Models\ComidaDiaria;
use App\Repositories\Contracts\ComidaDiariaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class ComidaDiariaService
{
    public function __construct(
        private readonly ComidaDiariaRepositoryInterface $comidaDiariaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->comidaDiariaRepository->all($perPage);
    }

    public function findOrFail(int $id): ComidaDiaria
    {
        return $this->comidaDiariaRepository->findOrFail($id);
    }

    public function create(StoreComidaDiariaPayload $payload): ComidaDiaria
    {
        return DB::transaction(
            fn () => $this->comidaDiariaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateComidaDiariaPayload $payload): ComidaDiaria
    {
        return DB::transaction(
            fn () => $this->comidaDiariaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->comidaDiariaRepository->delete($id));
    }
}
