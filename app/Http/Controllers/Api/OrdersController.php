<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderRequest;
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
        $message = $this->service->store($request)
            ? trans('statuses.stored')
            : trans('errors.0');

        return api_response($message);
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
        $message = $this->service->update($request, $order)
            ? trans('statuses.updated')
            : trans('errors.0');

        return api_response($message);
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
        $message = $this->service->destroy($order)
            ? trans('statuses.deleted')
            : trans('errors.0');

        return api_response($message);
    }
}
