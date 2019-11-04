<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Services\OrdersService;

use function api_response;
use function trans;

class OrdersController extends Controller
{
    private $service;

    public function __construct(OrdersService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $items = $this->service->index();

        return api_response($items);
    }

    /**
     * @param OrderRequest $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function store(OrderRequest $request)
    {
        if ($this->service->store($request)) {
            return api_response(trans('statuses.stored'));
        }

        return api_response(trans('errors.0'), 400);
    }

    public function show(Order $order)
    {
        $item = $this->service->show($order);

        return api_response($item);
    }

    /**
     * @param OrderRequest $request
     * @param Order $order
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(OrderRequest $request, Order $order)
    {
        if ($this->service->update($request, $order)) {
            return api_response(trans('statuses.updated'));
        }

        return api_response(trans('errors.0'), 400);
    }

    /**
     * @param Order $order
     *
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function destroy(Order $order)
    {
        if ($this->service->destroy($order)) {
            return api_response(trans('statuses.deleted'));
        }

        return api_response(trans('errors.0'), 400);
    }
}
