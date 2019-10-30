<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(VendorsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);

        $this->call(PartnersTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
    }
}
