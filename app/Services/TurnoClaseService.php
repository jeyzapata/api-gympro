<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\TurnoClase\StoreTurnoClasePayload;
use App\DTOs\TurnoClase\UpdateTurnoClasePayload;
use App\Models\TurnoClase;
use App\Repositories\Contracts\TurnoClaseRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class TurnoClaseService
{
    public function __construct(
        private readonly TurnoClaseRepositoryInterface $turnoClaseRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->turnoClaseRepository->all($perPage);
    }

    public function findOrFail(int $id): TurnoClase
    {
        return $this->turnoClaseRepository->findOrFail($id);
    }

    public function create(StoreTurnoClasePayload $payload): TurnoClase
    {
        return DB::transaction(
            fn () => $this->turnoClaseRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateTurnoClasePayload $payload): TurnoClase
    {
        return DB::transaction(
            fn () => $this->turnoClaseRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->turnoClaseRepository->delete($id));
    }
}
