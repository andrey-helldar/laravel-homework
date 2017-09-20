<?php

use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            \DB::table('vendors')->insert([ //,
				'email' => $faker->unique()->email,
                'name' => $faker->unique()->company,                               
            ]);
        }
    }
}
