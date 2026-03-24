<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Equipo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EquipoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Equipo;
    public function create(array $data): Equipo;
    public function update(int $id, array $data): Equipo;
    public function delete(int $id): void;
}
