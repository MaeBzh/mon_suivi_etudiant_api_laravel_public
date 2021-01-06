<?php

namespace Database\Seeders;

use App\Models\Diploma;
use App\Models\SkillTemplate;
use Illuminate\Database\Seeder;

class DiplomaSkillTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Diploma::factory()
        ->create()
        ->each(function ($diploma) {
            $skills = SkillTemplate::query()->inRandomOrder()->limit(5)->get();
            $diploma->skillTemplates()->attach($skills);
        });
    }
}
