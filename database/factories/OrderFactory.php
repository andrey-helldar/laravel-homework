<?php

use App\Models\Order;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Order::class, function (Faker $faker) {
    $created_at = Carbon::now()->subDays(rand(0, 4));
    $status     = [0, 10, 20];

    return [
        'status'       => $status[rand(0, 2)],
        'client_email' => $faker->safeEmail,
        'partner_id'   => $faker->numberBetween(1, 20),
        'delivery_at'  => $created_at->copy()->addHours(rand(6, 50)),
        'created_at'   => $created_at,
        'updated_at'   => $created_at->copy()->addHours(rand(1, 5)),
    ];
});
