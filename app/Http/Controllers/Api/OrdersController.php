<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

use function api_response;

class OrdersController extends Controller
{
    public function index()
    {
        return api_response([]);
    }

    public function store(Request $request)
    {
        return api_response();
    }

    public function show(Order $order)
    {
        return api_response($order);
    }

    public function edit(Order $order)
    {
        return api_response('ok');
    }

    public function update(Request $request, Order $order)
    {
        return api_response('ok');
    }

    public function destroy(Order $order)
    {
        return api_response('ok');
    }
}
