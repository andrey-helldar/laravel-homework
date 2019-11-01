<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProductsService
{
    public function index(): ?Collection
    {
        return Product::get();
    }

    public function store(Request $request): bool
    {
        return true;
    }

    public function show(Product $product): Product
    {
        return $product;
    }

    public function update(Request $request, Product $product): bool
    {
        return true;
    }

    public function destroy(Product $product): bool
    {
        return true;
    }
}
