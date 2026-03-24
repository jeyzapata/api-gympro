<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanPlataforma\StoreRequest;
use App\Http\Requests\PlanPlataforma\UpdateRequest;
use App\Http\Resources\PlanPlataformaResource;
use App\Services\PlanPlataformaService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PlanPlataformaController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PlanPlataformaService $planPlataformaService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return PlanPlataformaResource::collection(
            $this->planPlataformaService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $plan = $this->planPlataformaService->create($request->payload());

        return $this->created(new PlanPlataformaResource($plan));
    }

    public function show(int $id): PlanPlataformaResource
    {
        return new PlanPlataformaResource(
            $this->planPlataformaService->findOrFail($id)
        );
    }

    public function update(UpdateRequest $request, int $id): PlanPlataformaResource
    {
        return new PlanPlataformaResource(
            $this->planPlataformaService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->planPlataformaService->delete($id);

        return $this->noContent();
    }
}
