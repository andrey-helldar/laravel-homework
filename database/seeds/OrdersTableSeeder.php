<?php

use App\Expansions\Database\Seeder;
use App\Models\Order;
use App\Models\OrderProduct;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $this->truncate(Order::class, OrderProduct::class);

        factory(Order::class, 1000)
            ->create()
            ->each(function (Order $order) {
                $order->products()->saveMany(

                    factory(OrderProduct::class, rand(1, 4))
                        ->make([
                            'created_at' => $order->created_at,
                            'updated_at' => $order->updated_at,
                        ])
                );
            });
    }
}
