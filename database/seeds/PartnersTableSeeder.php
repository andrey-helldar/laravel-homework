<?php

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 20;

        for ($i = 0; $i < $limit; $i++) {
            Partner::create([
                'email' => $faker->unique()->email,
                'name'  => $faker->unique()->company,
            ]);
        }
    }
}
