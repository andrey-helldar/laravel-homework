<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([VendorsSeeder::class, ProductsSeeder::class, PartnersSeeder::class]);

        $this->call([OrdersSeeder::class, OrderProductsSeeder::class]);
    }
}
