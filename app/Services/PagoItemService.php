<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\PagoItem\StorePagoItemPayload;
use App\DTOs\PagoItem\UpdatePagoItemPayload;
use App\Models\PagoItem;
use App\Repositories\Contracts\PagoItemRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PagoItemService
{
    public function __construct(
        private readonly PagoItemRepositoryInterface $pagoItemRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->pagoItemRepository->all($perPage);
    }

    public function findOrFail(int $id): PagoItem
    {
        return $this->pagoItemRepository->findOrFail($id);
    }

    public function create(StorePagoItemPayload $payload): PagoItem
    {
        return DB::transaction(
            fn () => $this->pagoItemRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePagoItemPayload $payload): PagoItem
    {
        return DB::transaction(
            fn () => $this->pagoItemRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->pagoItemRepository->delete($id));
    }
}
