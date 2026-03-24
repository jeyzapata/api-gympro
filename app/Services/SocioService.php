<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Socio\StoreSocioPayload;
use App\DTOs\Socio\UpdateSocioPayload;
use App\Models\Socio;
use App\Repositories\Contracts\SocioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class SocioService
{
    public function __construct(
        private readonly SocioRepositoryInterface $socioRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->socioRepository->all($perPage);
    }

    public function findOrFail(int $id): Socio
    {
        return $this->socioRepository->findOrFail($id);
    }

    public function create(StoreSocioPayload $payload): Socio
    {
        return DB::transaction(
            fn () => $this->socioRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateSocioPayload $payload): Socio
    {
        return DB::transaction(
            fn () => $this->socioRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->socioRepository->delete($id));
    }
}
