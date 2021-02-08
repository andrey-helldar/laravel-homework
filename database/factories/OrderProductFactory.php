<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderProductFactory extends Factory
{
    protected $model = OrderProduct::class;

    public function definition(): array
    {
        $order   = $this->order();
        $product = $this->product();

        return [
            'order_id'   => $order->id,
            'product_id' => $product->id,

            'quantity' => $this->faker->numberBetween(1, 4),
            'price'    => $product->price,
        ];
    }

    protected function order(): Order
    {
        return Order::inRandomOrder()->first();
    }

    protected function product(): Product
    {
        return Product::inRandomOrder()->first();
    }
}
