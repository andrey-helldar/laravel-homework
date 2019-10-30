<?php

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        $limit = 10;

        for ($i = 0; $i < $limit; $i++) {
            Vendor::create([
                'email' => $faker->unique()->email,
                'name'  => $faker->unique()->company,
            ]);
        }
    }
}
