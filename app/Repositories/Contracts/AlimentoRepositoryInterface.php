<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Alimento;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AlimentoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Alimento;
    public function create(array $data): Alimento;
    public function update(int $id, array $data): Alimento;
    public function delete(int $id): void;
}
