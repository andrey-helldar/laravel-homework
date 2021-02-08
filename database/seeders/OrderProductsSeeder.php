<?php

namespace Database\Seeders;

use App\Models\OrderProduct;
use Illuminate\Database\Seeder;

final class OrderProductsSeeder extends Seeder
{
    public function run()
    {
        OrderProduct::factory()
            ->count(4000)
            ->create();
    }
}
