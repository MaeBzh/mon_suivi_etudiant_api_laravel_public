<?php

namespace Database\Factories;

use App\Models\DiplomaSkillTemplate;
use App\Models\DiplomaStudent;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiplomaStudentFactory extends Factory
{
    protected $model = DiplomaSkillTemplate::class;

    public function definition()
    {
        $strings = array('obtained', 'in_progress', 'failed');

        return [
            'start_year' => $this->faker->year(),
            'end_year' => $this->faker->year() + 2,
            'state' => array_rand($strings),
            'diploma_id' => function () {
                return DiplomaStudent::factory();
            },
            'student_id' => function () {
                return Student::factory();
            }
        ];
    }
}
