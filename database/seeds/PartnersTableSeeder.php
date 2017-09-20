<?php

use Illuminate\Database\Seeder;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 20;

        for ($i = 0; $i < $limit; $i++) {
            \DB::table('partners')->insert([ //,
				'email' => $faker->unique()->email,
                'name' => $faker->unique()->company,                               
            ]);
        }
    }
}
