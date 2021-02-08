<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;

final class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $date = $this->date();

        return [
            'status'       => $this->getRandomStatus(),
            'client_email' => $this->faker->safeEmail,

            'partner_id' => $this->getPartnerId(),

            'delivery_at' => $date->copy()->addHours(rand(6, 50)),
            'created_at'  => $date,
            'updated_at'  => $date->copy()->addHours(1, 5),
        ];
    }

    protected function statuses(): array
    {
        return [0, 10, 20];
    }

    protected function getRandomStatus(): int
    {
        return Arr::random($this->statuses());
    }

    protected function getPartnerId(): int
    {
        return Partner::inRandomOrder()->first()->id;
    }

    protected function date(): Carbon
    {
        return Carbon::now()->subDays(rand(0, 4));
    }
}
