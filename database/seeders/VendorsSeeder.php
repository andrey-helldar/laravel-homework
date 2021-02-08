<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

final class VendorsSeeder extends Seeder
{
    public function run()
    {
        Vendor::factory()->count(10)->create();
    }
}
