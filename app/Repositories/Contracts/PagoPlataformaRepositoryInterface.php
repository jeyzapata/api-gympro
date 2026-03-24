<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\PagoPlataforma;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PagoPlataformaRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): PagoPlataforma;
    public function create(array $data): PagoPlataforma;
    public function update(int $id, array $data): PagoPlataforma;
    public function delete(int $id): void;
}
