<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Membresia\StoreMembresiaPayload;
use App\DTOs\Membresia\UpdateMembresiaPayload;
use App\Models\Membresia;
use App\Repositories\Contracts\MembresiaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class MembresiaService
{
    public function __construct(
        private readonly MembresiaRepositoryInterface $membresiaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->membresiaRepository->all($perPage);
    }

    public function findOrFail(int $id): Membresia
    {
        return $this->membresiaRepository->findOrFail($id);
    }

    public function create(StoreMembresiaPayload $payload): Membresia
    {
        return DB::transaction(
            fn () => $this->membresiaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdateMembresiaPayload $payload): Membresia
    {
        return DB::transaction(
            fn () => $this->membresiaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->membresiaRepository->delete($id));
    }
}
