<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\MedicionSocio\StoreMedicionSocioPayload;
use App\DTOs\MedicionSocio\UpdateMedicionSocioPayload;
use App\Models\MedicionSocio;
use App\Repositories\Contracts\MedicionSocioRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class MedicionSocioService
{
    public function __construct(
        private readonly MedicionSocioRepositoryInterface $medicionSocioRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->medicionSocioRepository->all($perPage);
    }

    public function findOrFail(int $id): MedicionSocio
    {
        return $this->medicionSocioRepository->findOrFail($id);
    }

    public function create(StoreMedicionSocioPayload $payload): MedicionSocio
    {
        return DB::transaction(
            fn () => $this->medicionSocioRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateMedicionSocioPayload $payload): MedicionSocio
    {
        return DB::transaction(
            fn () => $this->medicionSocioRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->medicionSocioRepository->delete($id));
    }
}
