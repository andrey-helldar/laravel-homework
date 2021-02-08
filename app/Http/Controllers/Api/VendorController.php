<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorDestroyRequest;
use App\Http\Requests\VendorRequest;
use App\Models\Vendor;
use App\Services\VendorsService;
use Symfony\Component\HttpFoundation\JsonResponse;

use function __;

class VendorController extends Controller
{
    public function __construct(
        protected VendorsService $service
    ) {
    }

    public function index(): JsonResponse
    {
        $items = $this->service->index();

        return $this->json($items);
    }

    public function store(VendorRequest $request): JsonResponse
    {
        return $this->service->store($request)
            ? $this->json(__('statuses.stored'))
            : $this->json(__('errors.0'), 400);
    }

    public function show(Vendor $vendor): JsonResponse
    {
        $item = $this->service->show($vendor);

        return $this->json($item);
    }

    public function update(VendorRequest $request, Vendor $vendor): JsonResponse
    {
        return $this->service->update($request, $vendor)
            ? $this->json(__('statuses.updated'))
            : $this->json(__('errors.0'), 400);
    }

    public function destroy(VendorDestroyRequest $request, Vendor $vendor): JsonResponse
    {
        return $this->service->destroy($vendor)
            ? $this->json(__('statuses.deleted'))
            : $this->json(__('errors.0'), 400);
    }
}
