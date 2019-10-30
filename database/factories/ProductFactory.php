<?php

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'      => $faker->unique()->word,
        'price'     => $faker->numberBetween(100, 1000),
        'vendor_id' => $faker->numberBetween(1, 10),
    ];
});
