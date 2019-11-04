<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Helldar\Support\Laravel\Models\ModelHelper;
use Illuminate\Database\Eloquent\Collection;

class ProductsService
{
    private $model;

    public function __construct(ModelHelper $model)
    {
        $this->model = $model;
    }

    public function index(): ?Collection
    {
        return Product::get()
            ->load('vendor');
    }

    /**
     * @param ProductRequest $request
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return Product
     */
    public function store(ProductRequest $request): Product
    {
        return Product::create(
            $this->model->onlyFillable(Product::class, $request)
        );
    }

    public function show(Product $product): Product
    {
        return $product->load('vendor');
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     *
     * @throws \Helldar\Support\Exceptions\Laravel\IncorrectModelException
     *
     * @return bool
     */
    public function update(ProductRequest $request, Product $product): bool
    {
        return $product->update(
            $this->model->onlyFillable($product, $request)
        );
    }

    /**
     * @param Product $product
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function destroy(Product $product): bool
    {
        return (bool) $product->delete();
    }
}
