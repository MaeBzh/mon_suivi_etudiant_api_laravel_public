<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\Debrief;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DebriefFactory extends Factory
{
    protected $model = Debrief::class;

    public function definition()
    {
        $data =  [
            'date' => $this->faker->date,
            'summary' => $this->faker->text($maxNbChars = 200),
            'student_id' => function () {
                return Student::factory();
            },
            'tutor_id' => function () {
                return Tutor::factory();
            },
            'contact_id' => function () {
                if (Contact::query()->exists()) {
                    return Contact::query()->inRandomOrder()->first()->getKey();
                } else {
                    return Contact::factory();
                }
            }
        ];

        return $data;
    }
}
