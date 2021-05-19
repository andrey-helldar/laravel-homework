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
        $data = $this->model()->onlyFillable(Product::class, $request);

        return Product::create($data);
    }

    public function show(Product $product): Product
    {
        return $product->loadMissing('vendor');
    }

    public function update(ProductRequest $request, Product $product): bool
    {
        $data = $this->model()->onlyFillable($product, $request);

        return $product->update($data);
    }

    public function destroy(Product $product): bool
    {
        return $product->delete();
    }
}
