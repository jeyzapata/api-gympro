<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clase\StoreRequest;
use App\Http\Requests\Clase\UpdateRequest;
use App\Http\Resources\ClaseResource;
use App\Services\ClaseService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class ClaseController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ClaseService $claseService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return ClaseResource::collection(
            $this->claseService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $clase = $this->claseService->create($request->payload());

        return $this->created(new ClaseResource($clase));
    }

    public function show(int $id): ClaseResource
    {
        return new ClaseResource($this->claseService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): ClaseResource
    {
        return new ClaseResource(
            $this->claseService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->claseService->delete($id);

        return $this->noContent();
    }
}
