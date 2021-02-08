<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductsService extends BaseService
{
    public function index(): ?Collection
    {
        return Product::get()->load('vendor');
    }

    public function store(ProductRequest $request): Product
    {
        return Product::create(
            $this->model()->onlyFillable(Product::class, $request)
        );
    }

    public function show(Product $product): Product
    {
        return $product->load('vendor');
    }

    public function update(ProductRequest $request, Product $product): bool
    {
        return $product->update(
            $this->model()->onlyFillable($product, $request)
        );
    }

    public function destroy(Product $product): bool
    {
        return $product->delete();
    }
}
