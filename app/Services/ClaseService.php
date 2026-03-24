<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Clase\StoreClasePayload;
use App\DTOs\Clase\UpdateClasePayload;
use App\Models\Clase;
use App\Repositories\Contracts\ClaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class ClaseService
{
    public function __construct(
        private readonly ClaseRepositoryInterface $claseRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->claseRepository->all($perPage);
    }

    public function findOrFail(int $id): Clase
    {
        return $this->claseRepository->findOrFail($id);
    }

    public function create(StoreClasePayload $payload): Clase
    {
        return DB::transaction(
            fn () => $this->claseRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateClasePayload $payload): Clase
    {
        return DB::transaction(
            fn () => $this->claseRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->claseRepository->delete($id));
    }
}
