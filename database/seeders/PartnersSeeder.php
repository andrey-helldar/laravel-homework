<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

final class PartnersSeeder extends Seeder
{
    public function run()
    {
        Partner::factory()->count(20)->create();
    }
}
