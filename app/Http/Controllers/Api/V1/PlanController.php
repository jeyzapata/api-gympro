<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan\StoreRequest;
use App\Http\Requests\Plan\UpdateRequest;
use App\Http\Resources\PlanResource;
use App\Services\PlanService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PlanController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PlanService $planService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return PlanResource::collection(
            $this->planService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $plan = $this->planService->create($request->payload());

        return $this->created(new PlanResource($plan));
    }

    public function show(int $id): PlanResource
    {
        return new PlanResource($this->planService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): PlanResource
    {
        return new PlanResource(
            $this->planService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->planService->delete($id);

        return $this->noContent();
    }
}
