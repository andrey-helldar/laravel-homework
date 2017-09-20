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

        for ($i = 0; $i < $limit; $i++) {
            \DB::table('orders')->insert([				
				//'status' => $faker->randomElements($a = [10, 20, 30]),				
				'status' => 10,				
				'client_email' => $faker->email,
			    'partner_id' => $faker->numberBetween(1, 20),			    			   
            ]);
        }
    }
}
