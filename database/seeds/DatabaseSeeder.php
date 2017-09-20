<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(VendorsTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
         
         $this->call(PartnersTableSeeder::class);
         $this->call(OrdersTableSeeder::class);
         $this->call(OrdersProductsTableSeeder::class);
    }
}
