<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Socio;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SocioRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): Socio;
    public function create(array $data): Socio;
    public function update(int $id, array $data): Socio;
    public function delete(int $id): void;
}
