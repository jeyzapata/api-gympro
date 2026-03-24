<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\PagoItem;
use App\Repositories\Contracts\PagoItemRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class PagoItemRepository implements PagoItemRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return PagoItem::with(['pago'])->orderByDesc('created_at')->paginate($perPage);
    }

    public function findOrFail(int $id): PagoItem
    {
        return PagoItem::with(['pago'])->findOrFail($id);
    }

    public function create(array $data): PagoItem
    {
        return PagoItem::create($data);
    }

    public function update(int $id, array $data): PagoItem
    {
        $pagoItem = $this->findOrFail($id);
        $pagoItem->update($data);
        return $pagoItem->fresh(['pago']);
    }

    public function delete(int $id): void
    {
        PagoItem::findOrFail($id)->delete();
    }
}
