<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->payload());

        if (! $result) {
            return $this->error('Credenciales incorrectas.', 401);
        }

        return $this->success([
            'token' => $result['token'],
            'user'  => new UserResource($result['user']),
        ], 'Login exitoso.');
    }

    public function me(): UserResource
    {
        return new UserResource(auth()->user()->load('userable'));
    }

    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->noContent();
    }
}
