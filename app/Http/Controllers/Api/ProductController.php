<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductDestroyRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductsService;
use Symfony\Component\HttpFoundation\JsonResponse;

use function __;

class ProductController extends Controller
{
    public function __construct(
        protected ProductsService $service
    ) {
    }

    public function index(): JsonResponse
    {
        $items = $this->service->index();

        return $this->json($items);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        return $this->service->store($request)
            ? $this->json(__('statuses.stored'))
            : $this->json(__('errors.0'), 400);
    }

    public function show(Product $product): JsonResponse
    {
        $item = $this->service->show($product);

        return $this->json($item);
    }

    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        return $this->service->update($request, $product)
            ? $this->json(__('statuses.updated'))
            : $this->json(__('errors.0'), 400);
    }

    public function destroy(ProductDestroyRequest $request, Product $product): JsonResponse
    {
        return $this->service->destroy($product)
            ? $this->json(__('statuses.deleted'))
            : $this->json(__('errors.0'), 400);
    }
}
