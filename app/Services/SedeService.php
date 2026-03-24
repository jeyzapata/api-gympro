<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Sede\StoreSedePayload;
use App\DTOs\Sede\UpdateSedePayload;
use App\Models\Sede;
use App\Repositories\Contracts\SedeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class SedeService
{
    public function __construct(
        private readonly SedeRepositoryInterface $sedeRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->sedeRepository->all($perPage);
    }

    public function findOrFail(int $id): Sede
    {
        return $this->sedeRepository->findOrFail($id);
    }

    public function create(StoreSedePayload $payload): Sede
    {
        return DB::transaction(
            fn () => $this->sedeRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateSedePayload $payload): Sede
    {
        return DB::transaction(
            fn () => $this->sedeRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->sedeRepository->delete($id));
    }
}
