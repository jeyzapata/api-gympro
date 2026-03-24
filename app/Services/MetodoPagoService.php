<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\MetodoPago\StoreMetodoPagoPayload;
use App\DTOs\MetodoPago\UpdateMetodoPagoPayload;
use App\Models\MetodoPago;
use App\Repositories\Contracts\MetodoPagoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class MetodoPagoService
{
    public function __construct(
        private readonly MetodoPagoRepositoryInterface $metodoPagoRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->metodoPagoRepository->all($perPage);
    }

    public function findOrFail(int $id): MetodoPago
    {
        return $this->metodoPagoRepository->findOrFail($id);
    }

    public function create(StoreMetodoPagoPayload $payload): MetodoPago
    {
        return DB::transaction(
            fn () => $this->metodoPagoRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateMetodoPagoPayload $payload): MetodoPago
    {
        return DB::transaction(
            fn () => $this->metodoPagoRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->metodoPagoRepository->delete($id));
    }
}
