<?php

use Illuminate\Database\Seeder;
use App\Product;

class OrdersProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 1000;
	
		$products = Product::get();
			
        for ($orderId = 1; $orderId <= $limit; $orderId++) {
			$pLimit = rand(1,4);
			for ($productsOrderCnt = 1; $productsOrderCnt <= $pLimit; $productsOrderCnt++) {
				$product = $products->random();
				\DB::table('order_products')->insert([				
					'order_id' => $orderId,
					'product_id' => $product->id,
					'quantity' => rand(1,3),
					'price' => $product->price,									
				]);
			}
        }
    }
}
