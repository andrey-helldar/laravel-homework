<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
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
        $status = [0, 10, 20];

        for ($i = 0; $i < $limit; $i++) {
            $createdAt = \Carbon\Carbon::now()->subDays(rand(0, 4));
            \DB::table('orders')->insert([				
				'status' => $status[rand(0,2)],
				'client_email' => $faker->email,
                'partner_id' => $faker->numberBetween(1, 20),
                'delivery_dt' => $createdAt->copy()->addHours(rand(6,50)),
                'created_at' => $createdAt,
                'updated_at' => $createdAt->copy()->addHours(rand(1,5)),
            ]);
        }
    }
}

