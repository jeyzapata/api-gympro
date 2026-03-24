<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class TenantController extends Controller
{
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

    public function show(int $id): TenantResource
    {
        return new TenantResource($this->tenantService->findOrFail($id));
    }
}
