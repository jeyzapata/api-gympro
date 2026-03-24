<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Promocion\StorePromocionPayload;
use App\DTOs\Promocion\UpdatePromocionPayload;
use App\Models\Promocion;
use App\Repositories\Contracts\PromocionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PromocionService
{
    public function __construct(
        private readonly PromocionRepositoryInterface $promocionRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->promocionRepository->all($perPage);
    }

    public function findOrFail(int $id): Promocion
    {
        return $this->promocionRepository->findOrFail($id);
    }

    public function create(StorePromocionPayload $payload): Promocion
    {
        return DB::transaction(
            fn () => $this->promocionRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePromocionPayload $payload): Promocion
    {
        return DB::transaction(
            fn () => $this->promocionRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->promocionRepository->delete($id));
    }
}
