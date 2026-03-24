<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\PagoPlataforma\StorePagoPlataformaPayload;
use App\DTOs\PagoPlataforma\UpdatePagoPlataformaPayload;
use App\Models\PagoPlataforma;
use App\Repositories\Contracts\PagoPlataformaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class PagoPlataformaService
{
    public function __construct(
        private readonly PagoPlataformaRepositoryInterface $pagoPlataformaRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->pagoPlataformaRepository->all($perPage);
    }

    public function findOrFail(int $id): PagoPlataforma
    {
        return $this->pagoPlataformaRepository->findOrFail($id);
    }

    public function create(StorePagoPlataformaPayload $payload): PagoPlataforma
    {
        return DB::transaction(
            fn () => $this->pagoPlataformaRepository->create($payload->toArray())
        );
    }

    public function update(int $id, UpdatePagoPlataformaPayload $payload): PagoPlataforma
    {
        return DB::transaction(
            fn () => $this->pagoPlataformaRepository->update($id, $payload->toArray())
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->pagoPlataformaRepository->delete($id));
    }
}
