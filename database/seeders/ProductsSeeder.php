<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

final class ProductsSeeder extends Seeder
{
    public function run()
    {
        Product::factory()->count(30)->create();
    }
}
