<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // if (App::environment() !== 'production') {
            $this->call([
                ContactSeeder::class,
                DebriefSeeder::class,
                DocumentSeeder::class,
                ScorecardSkillSeeder::class,
                DiplomaSkillTemplateSeeder::class,
                DiplomaStudentSeeder::class,
                AdminSeeder::class
            ]);
        // }
    }
}
