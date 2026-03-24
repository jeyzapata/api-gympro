<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Reserva\StoreReservaPayload;
use App\DTOs\Reserva\UpdateReservaPayload;
use App\Models\Reserva;
use App\Repositories\Contracts\ReservaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class ReservaService
{
    public function __construct(
        private readonly ReservaRepositoryInterface $reservaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->reservaRepository->all($perPage);
    }

    public function findOrFail(int $id): Reserva
    {
        return $this->reservaRepository->findOrFail($id);
    }

    public function create(StoreReservaPayload $payload): Reserva
    {
        return DB::transaction(
            fn () => $this->reservaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateReservaPayload $payload): Reserva
    {
        return DB::transaction(
            fn () => $this->reservaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->reservaRepository->delete($id));
    }
}
