<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\User\StoreUserPayload;
use App\DTOs\User\UpdateUserPayload;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

final class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function getAll(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->all($perPage);
    }

    public function findOrFail(int $id): User
    {
        return $this->userRepository->findOrFail($id);
    }

    public function create(StoreUserPayload $payload): User
    {
        $data = $payload->toArray();
        $data['password'] = Hash::make($data['password']);

        return DB::transaction(
            fn () => $this->userRepository->create($data)
        );
    }

    public function update(int $id, UpdateUserPayload $payload): User
    {
        $data = $payload->toArray();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return DB::transaction(
            fn () => $this->userRepository->update($id, $data)
        );
    }

    public function delete(int $id): void
    {
        DB::transaction(fn () => $this->userRepository->delete($id));
    }

    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }
}
