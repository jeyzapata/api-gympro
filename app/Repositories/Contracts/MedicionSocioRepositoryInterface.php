<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\MedicionSocio;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface MedicionSocioRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator;
    public function findOrFail(int $id): MedicionSocio;
    public function create(array $data): MedicionSocio;
    public function update(int $id, array $data): MedicionSocio;
    public function delete(int $id): void;
}
