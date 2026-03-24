<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\CategoriaEquipo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CategoriaEquipoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): CategoriaEquipo;
    public function create(array $data): CategoriaEquipo;
    public function update(int $id, array $data): CategoriaEquipo;
    public function delete(int $id): void;
}
