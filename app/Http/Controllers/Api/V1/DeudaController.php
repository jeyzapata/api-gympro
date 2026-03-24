<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Deuda\StoreRequest;
use App\Http\Requests\Deuda\UpdateRequest;
use App\Http\Resources\DeudaResource;
use App\Services\DeudaService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class DeudaController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly DeudaService $deudaService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return DeudaResource::collection(
            $this->deudaService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $deuda = $this->deudaService->create($request->payload());

        return $this->created(new DeudaResource($deuda));
    }

    public function show(int $id): DeudaResource
    {
        return new DeudaResource($this->deudaService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): DeudaResource
    {
        return new DeudaResource(
            $this->deudaService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->deudaService->delete($id);

        return $this->noContent();
    }
}
