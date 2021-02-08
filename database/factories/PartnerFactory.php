<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

final class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'name'  => $this->faker->unique()->company,
        ];
    }
}
