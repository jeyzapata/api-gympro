<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Http\Requests\Tenant\StoreRequest;
use App\Http\Requests\Tenant\UpdateRequest;
use App\Http\Resources\TenantCollection;
use App\Http\Resources\TenantResource;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class TenantController extends Controller
{
    public function index(Request $request): TenantCollection
    {
        $tenants = Tenant::all();

        return new TenantCollection($tenants);
    }

    public function store(StoreRequest $request): TenantResource
    {
        $tenant = Tenant::create($request->validated());

        return new TenantResource($tenant);
    }

    public function show(Request $request, Tenant $tenant): TenantResource
    {
        return new TenantResource($tenant);
    }

    public function update(UpdateRequest $request, Tenant $tenant): TenantResource
    {
        $tenant->update($request->validated());

        return new TenantResource($tenant);
    }

    public function destroy(Request $request, Tenant $tenant): Response
    {
        $tenant->delete();

        return response()->noContent();
    }
}
