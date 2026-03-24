<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PagoPlataforma\StoreRequest;
use App\Http\Requests\PagoPlataforma\UpdateRequest;
use App\Http\Resources\PagoPlataformaResource;
use App\Services\PagoPlataformaService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class PagoPlataformaController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly PagoPlataformaService $pagoPlataformaService
    ) {}

    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->integer('per_page', 15), 100);

        return PagoPlataformaResource::collection(
            $this->pagoPlataformaService->getAll($perPage)
        );
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $pago = $this->pagoPlataformaService->create($request->payload());

        return $this->created(new PagoPlataformaResource($pago));
    }

    public function show(int $id): PagoPlataformaResource
    {
        return new PagoPlataformaResource(
            $this->pagoPlataformaService->findOrFail($id)
        );
    }

    public function update(UpdateRequest $request, int $id): PagoPlataformaResource
    {
        return new PagoPlataformaResource(
            $this->pagoPlataformaService->update($id, $request->payload())
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->pagoPlataformaService->delete($id);

        return $this->noContent();
    }
}
