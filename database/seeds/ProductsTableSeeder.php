<?php

use App\Expansions\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $this->truncate(Product::class);

        factory(Product::class, 30)->create();
    }
}
