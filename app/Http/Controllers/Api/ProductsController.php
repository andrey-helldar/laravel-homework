<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
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

    /**
     * @param ProductRequest $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function store(ProductRequest $request)
    {
        return $this->service->store($request)
            ? api_response(trans('statuses.stored'))
            : api_response(trans('errors.0'), 400);
    }

    public function show(Product $product)
    {
        $item = $this->service->show($product);

        return api_response($item);
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        return $this->service->update($request, $product)
            ? api_response(trans('statuses.updated'))
            : api_response(trans('errors.0'), 400);
    }

    /**
     * @param Request $request
     * @param Product $product
     *
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function destroy(Request $request, Product $product)
    {
        $request->request->add(['count' => $product->orders()->count()]);

        $this->validate($request,
            ['count' => ['required', 'integer', 'size:0']],
            ['count.size' => trans('validation.product_used', ['name' => $product->name])]
        );

        return $this->service->destroy($product)
            ? api_response(trans('statuses.deleted'))
            : api_response(trans('errors.0'), 400);
    }
}
