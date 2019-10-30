<?php

use App\Models\Vendor;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'name'  => $faker->unique()->company,
    ];
});
