<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pago\StoreRequest;
use App\Http\Requests\Pago\UpdateRequest;
use App\Http\Resources\PagoResource;
use App\Services\PagoService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PagoController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PagoService $pagoService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return PagoResource::collection(
            $this->pagoService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $pago = $this->pagoService->create($request->payload());

        return $this->created(new PagoResource($pago));
    }

    public function show(int $id): PagoResource
    {
        return new PagoResource($this->pagoService->findOrFail($id));
    }

    public function update(UpdateRequest $request, int $id): PagoResource
    {
        return new PagoResource(
            $this->pagoService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->pagoService->delete($id);

        return $this->noContent();
    }
}
