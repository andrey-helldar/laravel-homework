<?php

use App\Models\Partner;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Partner::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'name'  => $faker->unique()->company,
    ];
});
