<?php

namespace Database\Seeders;

use App\Models\Scorecard;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class ScorecardSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Scorecard::factory()
        ->create()
        ->each(function ($scorecard) {
            $skills = Skill::factory()->times(5)->create();
            $scorecard->skills()->attach($skills);
        });
    }
}
