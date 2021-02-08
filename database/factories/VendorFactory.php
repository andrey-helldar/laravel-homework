<?php

namespace Database\Factories;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Factories\Factory;

final class VendorFactory extends Factory
{
    protected $model = Vendor::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'name'  => $this->faker->unique()->company,
        ];
    }
}
