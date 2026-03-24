<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sede\StoreRequest;
use App\Http\Requests\Sede\UpdateRequest;
use App\Http\Resources\SedeResource;
use App\Services\SedeService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class SedeController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly SedeService $sedeService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);
        return SedeResource::collection(
            $this->sedeService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $sede = $this->sedeService->create($request->payload());
        return $this->created(new SedeResource($sede));
    }

    public function show(int $id): SedeResource
    {
        return new SedeResource($this->sedeService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): SedeResource
    {
        return new SedeResource(
            $this->sedeService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->sedeService->delete($id);
        return $this->noContent();
    }
}
