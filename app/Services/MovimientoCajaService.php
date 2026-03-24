<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\MovimientoCaja\StoreMovimientoCajaPayload;
use App\DTOs\MovimientoCaja\UpdateMovimientoCajaPayload;
use App\Models\MovimientoCaja;
use App\Repositories\Contracts\MovimientoCajaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class MovimientoCajaService
{
    public function __construct(
        private readonly MovimientoCajaRepositoryInterface $movimientoCajaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->movimientoCajaRepository->all($perPage);
    }

    public function findOrFail(int $id): MovimientoCaja
    {
        return $this->movimientoCajaRepository->findOrFail($id);
    }

    public function create(StoreMovimientoCajaPayload $payload): MovimientoCaja
    {
        return DB::transaction(
            fn () => $this->movimientoCajaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateMovimientoCajaPayload $payload): MovimientoCaja
    {
        return DB::transaction(
            fn () => $this->movimientoCajaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->movimientoCajaRepository->delete($id));
    }
}
