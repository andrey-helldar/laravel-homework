<?php

use App\Expansions\Database\Seeder;
use App\Models\Partner;

class PartnersTableSeeder extends Seeder
{
    public function run()
    {
        $this->truncate(Partner::class);

        factory(Partner::class, 20)->create();
    }
}
