<?php

namespace Database\Seeders;

use App\Models\Debrief;
use Illuminate\Database\Seeder;

class DebriefSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Debrief::factory()
        ->create();
    }
}
