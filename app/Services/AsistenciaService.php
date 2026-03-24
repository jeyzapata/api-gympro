<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Asistencia\StoreAsistenciaPayload;
use App\DTOs\Asistencia\UpdateAsistenciaPayload;
use App\Models\Asistencia;
use App\Repositories\Contracts\AsistenciaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class AsistenciaService
{
    public function __construct(
        private readonly AsistenciaRepositoryInterface $asistenciaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->asistenciaRepository->all($perPage);
    }

    public function findOrFail(int $id): Asistencia
    {
        return $this->asistenciaRepository->findOrFail($id);
    }

    public function create(StoreAsistenciaPayload $payload): Asistencia
    {
        return DB::transaction(
            fn () => $this->asistenciaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateAsistenciaPayload $payload): Asistencia
    {
        return DB::transaction(
            fn () => $this->asistenciaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->asistenciaRepository->delete($id));
    }
}
