<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\AdminUserResource;
use App\Services\AdminAuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

final class AdminAuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AdminAuthService $adminAuthService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->adminAuthService->login($request->payload());

        if (! $result) {
            return $this->error('Credenciales incorrectas.', 401);
        }

        return $this->success([
            'token' => $result['token'],
            'user'  => new AdminUserResource($result['user']),
        ], 'Login exitoso.');
    }

    public function me(): AdminUserResource
    {
        return new AdminUserResource(auth('admin')->user());
    }

    public function logout(): JsonResponse
    {
        auth('admin')->user()->currentAccessToken()->delete();

        return $this->noContent();
    }
}
