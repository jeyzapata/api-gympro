<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class UserRepository implements UserRepositoryInterface
{
    public function all(int $perPage = 15): LengthAwarePaginator
    {
        return User::with('userable')->latest()->paginate($perPage);
    }

    public function findOrFail(int $id): User
    {
        return User::with('userable')->findOrFail($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);

        return $user->fresh('userable');
    }

    public function delete(int $id): void
    {
        User::findOrFail($id)->delete();
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }
}
