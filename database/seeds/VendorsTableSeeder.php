<?php

use Illuminate\Database\Seeder;

use App\Vendor;

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
            // \DB::table('vendors')->insert([ //,
            //     'created_at' => \Carbon\Carbon::now(),
            //     'updated_at' => \Carbon\Carbon::now(),
            // ]);
            Vendor::create([
                'email' => $faker->unique()->email,
                'name' => $faker->unique()->company,
            ]);
        }
    }
}
