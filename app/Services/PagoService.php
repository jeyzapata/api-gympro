<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Pago\StorePagoPayload;
use App\DTOs\Pago\UpdatePagoPayload;
use App\Models\Pago;
use App\Repositories\Contracts\PagoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PagoService
{
    public function __construct(
        private readonly PagoRepositoryInterface $pagoRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->pagoRepository->all($perPage);
    }

    public function findOrFail(int $id): Pago
    {
        return $this->pagoRepository->findOrFail($id);
    }

    public function create(StorePagoPayload $payload): Pago
    {
        return DB::transaction(
            fn () => $this->pagoRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePagoPayload $payload): Pago
    {
        return DB::transaction(
            fn () => $this->pagoRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->pagoRepository->delete($id));
    }
}
