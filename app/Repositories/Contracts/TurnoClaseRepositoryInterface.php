<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\TurnoClase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TurnoClaseRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): TurnoClase;
    public function create(array $data): TurnoClase;
    public function update(int $id, array $data): TurnoClase;
    public function delete(int $id): void;
}
