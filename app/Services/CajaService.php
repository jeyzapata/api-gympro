<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Caja\StoreCajaPayload;
use App\DTOs\Caja\UpdateCajaPayload;
use App\Models\Caja;
use App\Repositories\Contracts\CajaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class CajaService
{
    public function __construct(
        private readonly CajaRepositoryInterface $cajaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->cajaRepository->all($perPage);
    }

    public function findOrFail(int $id): Caja
    {
        return $this->cajaRepository->findOrFail($id);
    }

    public function create(StoreCajaPayload $payload): Caja
    {
        return DB::transaction(
            fn () => $this->cajaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateCajaPayload $payload): Caja
    {
        return DB::transaction(
            fn () => $this->cajaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->cajaRepository->delete($id));
    }
}
