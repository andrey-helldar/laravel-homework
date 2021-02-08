<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PartnerDestroyRequest;
use App\Http\Requests\PartnerRequest;
use App\Models\Partner;
use App\Services\PartnersService;
use Symfony\Component\HttpFoundation\JsonResponse;

use function __;

class PartnerController extends Controller
{
    public function __construct(
        protected PartnersService $service
    ) {
    }

    public function index(): JsonResponse
    {
        $items = $this->service->index();

        return $this->json($items);
    }

    public function store(PartnerRequest $request): JsonResponse
    {
        return $this->service->store($request)
            ? $this->json(__('statuses.stored'))
            : $this->json(__('errors.0'), 400);
    }

    public function show(Partner $partner): JsonResponse
    {
        $item = $this->service->show($partner);

        return $this->json($item);
    }

    public function update(PartnerRequest $request, Partner $partner): JsonResponse
    {
        return $this->service->update($request, $partner)
            ? $this->json(__('statuses.updated'))
            : $this->json(__('errors.0'), 400);
    }

    public function destroy(PartnerDestroyRequest $request, Partner $partner): JsonResponse
    {
        return $this->service->destroy($partner)
            ? $this->json(__('statuses.deleted'))
            : $this->json(__('errors.0'), 400);
    }
}
