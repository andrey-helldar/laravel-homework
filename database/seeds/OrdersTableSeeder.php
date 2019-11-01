<?php

use App\Expansions\Database\Seeder;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $this->truncate(Order::class, OrderProduct::class);

        factory(Order::class, 1000)
            ->create()
            ->each(function (Order $order) {

                for ($i = 0; $i < rand(1, 4); $i++) {
                    $product    = $this->product();
                    $quantity   = rand(1, 3);
                    $price      = $product->price;
                    $created_at = $order->created_at;
                    $updated_at = $order->updated_at;

                    $order->products()->attach(
                        $product->id,
                        compact('quantity', 'price', 'created_at', 'updated_at')
                    );
                }
            });
    }

    private function product(): Product
    {
        return Product::query()
            ->inRandomOrder()
            ->first();
    }
}
