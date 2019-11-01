<?php

use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(OrderProduct::class, function () {
    $product  = Product::query()->inRandomOrder()->first();
    $quantity = rand(1, 3);

    return [
        'product_id' => $product->id,
        'quantity'   => $quantity,
        'price'      => $product->price,
    ];
});
