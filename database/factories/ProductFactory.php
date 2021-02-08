<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name'  => $this->faker->unique()->word,
            'price' => $this->faker->numberBetween(100, 1000),

            'vendor_id' => $this->getVendorId(),
        ];
    }

    protected function getVendorId()
    {
        return Vendor::inRandomOrder()->first()->id;
    }
}
