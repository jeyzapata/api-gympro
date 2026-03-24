<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\ComidaAlimento;
use App\Repositories\Contracts\ComidaAlimentoRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ComidaAlimentoRepository implements ComidaAlimentoRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return ComidaAlimento::with(['comidaDiaria', 'alimento'])->orderByDesc('created_at')->paginate($perPage);
    }

    public function findOrFail(int $id): ComidaAlimento
    {
        return ComidaAlimento::with(['comidaDiaria', 'alimento'])->findOrFail($id);
    }

    public function create(array $data): ComidaAlimento
    {
        return ComidaAlimento::create($data);
    }

    public function update(int $id, array $data): ComidaAlimento
    {
        $comidaAlimento = $this->findOrFail($id);
        $comidaAlimento->update($data);
        return $comidaAlimento->fresh(['comidaDiaria', 'alimento']);
    }

    public function delete(int $id): void
    {
        ComidaAlimento::findOrFail($id)->delete();
    }
}
