<?php

namespace Database\Seeders;

use App\Models\Diploma;
use App\Models\DiplomaStudent;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DiplomaStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::get()->each(function (Student $student) {
            $diplomas = Diploma::query()->inRandomOrder()->limit(2)->get();
            $student->diplomas()->attach($diplomas, ['start_year' => '2018', 'end_year' => '2020', 'state' => DiplomaStudent::OBTAINED]);
        });
    }
}
