<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductsService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    private $service;

    public function __construct(ProductsService $service)
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

    public function show(Product $product)
    {
        $item = $this->service->show($product);

        return api_response($item);
    }

    public function update(Request $request, Product $product)
    {
        $message = $this->service->update($request, $product)
            ? trans('statuses.updated')
            : trans('errors.0');

        return api_response($message);
    }

    public function destroy(Product $product)
    {
        $message = $this->service->destroy($product)
            ? trans('statuses.deleted')
            : trans('errors.0');

        return api_response($message);
    }
}
