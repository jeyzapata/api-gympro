<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\ComidaAlimento;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ComidaAlimentoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): ComidaAlimento;
    public function create(array $data): ComidaAlimento;
    public function update(int $id, array $data): ComidaAlimento;
    public function delete(int $id): void;
}
