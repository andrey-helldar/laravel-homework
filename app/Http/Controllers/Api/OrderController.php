<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\OrdersService;
use Symfony\Component\HttpFoundation\JsonResponse;

use function __;

class OrderController extends Controller
{
    public function __construct(
        protected OrdersService $service
    ) {
    }

    public function index(): JsonResponse
    {
        $items = $this->service->index();

        return $this->json($items);
    }

    public function store(OrderRequest $request): JsonResponse
    {
        return $this->service->store($request)
            ? $this->json(__('statuses.stored'))
            : $this->json(__('errors.0'), 400);
    }

    public function show(Order $order): JsonResponse
    {
        $item = $this->service->show($order);

        return $this->json($item);
    }

    public function update(OrderRequest $request, Order $order): JsonResponse
    {
        return $this->service->update($request, $order)
            ? $this->json(__('statuses.updated'))
            : $this->json(__('errors.0'), 400);
    }

    public function destroy(Order $order): JsonResponse
    {
        return $this->service->destroy($order)
            ? $this->json(__('statuses.deleted'))
            : $this->json(__('errors.0'), 400);
    }
}
