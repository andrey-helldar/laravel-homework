<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrdersService;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $message = $this->service->store($request)
            ? trans('statuses.stored')
            : trans('errors.0');

        return api_response($message);
    }

    public function show(Order $order)
    {
        return api_response($order);
    }

    public function update(Request $request, Order $order)
    {
        $message = $this->service->update($request, $order)
            ? trans('statuses.updated')
            : trans('errors.0');

        return api_response($message);
    }

    public function destroy(Order $order)
    {
        $message = $this->service->destroy($order)
            ? trans('statuses.deleted')
            : trans('errors.0');

        return api_response($message);
    }
}
