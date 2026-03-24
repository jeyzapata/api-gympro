<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreRequest;
use App\Http\Requests\Tenant\UpdateRequest;
use App\Http\Resources\TenantResource;
use App\Services\TenantService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class AdminTenantController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly TenantService $tenantService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return TenantResource::collection(
            $this->tenantService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $tenant = $this->tenantService->create($request->payload());

        return $this->created(new TenantResource($tenant));
    }

    public function show(int $id): TenantResource
    {
        return new TenantResource($this->tenantService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): TenantResource
    {
        return new TenantResource(
            $this->tenantService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->tenantService->delete($id);

        return $this->noContent();
    }
}
