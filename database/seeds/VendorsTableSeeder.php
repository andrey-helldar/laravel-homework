<?php

use App\Expansions\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    public function run()
    {
        $this->truncate(Vendor::class);

        factory(Vendor::class, 10)->create();
    }
}
