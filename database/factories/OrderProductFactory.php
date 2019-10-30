<?php

use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(OrderProduct::class, function () {
    $product = Product::query()->inRandomOrder()->first();

    return [
        'product_id' => $product->id,
        'quantity'   => rand(1, 3),
        'price'      => $product->price,
    ];
});
