<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;

final class OrdersSeeder extends Seeder
{
    public function run()
    {
        Order::factory()->count(1000)->create();
    }
}
