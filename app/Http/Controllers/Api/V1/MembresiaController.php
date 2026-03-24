<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Membresia\StoreRequest;
use App\Http\Requests\Membresia\UpdateRequest;
use App\Http\Resources\MembresiaResource;
use App\Services\MembresiaService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class MembresiaController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly MembresiaService $membresiaService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return MembresiaResource::collection(
            $this->membresiaService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $membresia = $this->membresiaService->create($request->payload());

        return $this->created(new MembresiaResource($membresia));
    }

    public function show(int $id): MembresiaResource
    {
        return new MembresiaResource($this->membresiaService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): MembresiaResource
    {
        return new MembresiaResource(
            $this->membresiaService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->membresiaService->delete($id);

        return $this->noContent();
    }
}
