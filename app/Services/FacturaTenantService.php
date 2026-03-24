<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\FacturaTenant\StoreFacturaTenantPayload;
use App\DTOs\FacturaTenant\UpdateFacturaTenantPayload;
use App\Models\FacturaTenant;
use App\Repositories\Contracts\FacturaTenantRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class FacturaTenantService
{
    public function __construct(
        private readonly FacturaTenantRepositoryInterface $facturaTenantRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->facturaTenantRepository->all($perPage);
    }

    public function findOrFail(int $id): FacturaTenant
    {
        return $this->facturaTenantRepository->findOrFail($id);
    }

    public function create(StoreFacturaTenantPayload $payload): FacturaTenant
    {
        return DB::transaction(
            fn () => $this->facturaTenantRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateFacturaTenantPayload $payload): FacturaTenant
    {
        return DB::transaction(
            fn () => $this->facturaTenantRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->facturaTenantRepository->delete($id));
    }
}
