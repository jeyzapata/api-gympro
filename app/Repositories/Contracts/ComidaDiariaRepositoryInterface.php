<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\ComidaDiaria;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ComidaDiariaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): ComidaDiaria;
    public function create(array $data): ComidaDiaria;
    public function update(int $id, array $data): ComidaDiaria;
    public function delete(int $id): void;
}
