<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FacturaTenant\StoreRequest;
use App\Http\Requests\FacturaTenant\UpdateRequest;
use App\Http\Resources\FacturaTenantResource;
use App\Services\FacturaTenantService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class FacturaTenantController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly FacturaTenantService $facturaTenantService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return FacturaTenantResource::collection(
            $this->facturaTenantService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $factura = $this->facturaTenantService->create($request->payload());

        return $this->created(new FacturaTenantResource($factura));
    }

    public function show(int $id): FacturaTenantResource
    {
        return new FacturaTenantResource(
            $this->facturaTenantService->findOrFail($id)
        );
    }

    public function update(UpdateRequest $request, int $id): FacturaTenantResource
    {
        return new FacturaTenantResource(
            $this->facturaTenantService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->facturaTenantService->delete($id);

        return $this->noContent();
    }
}
