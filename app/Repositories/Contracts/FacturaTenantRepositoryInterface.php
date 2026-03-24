<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\FacturaTenant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface FacturaTenantRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): FacturaTenant;
    public function create(array $data): FacturaTenant;
    public function update(int $id, array $data): FacturaTenant;
    public function delete(int $id): void;
}
