<?php

namespace Database\Factories;

use App\Models\Diploma;
use App\Models\Scorecard;
use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScorecardFactory extends Factory
{
    protected $model = Scorecard::class;

    public function definition()
    {
        return [
            'name'=> $this->faker->words($nb=5, $asText=true),
            'student_id' => function() {
                if(Student::query()->exists()){
                    return Student::query()->inRandomOrder()->first()->getKey();
                }

                return Student::factory();
            },
            'diploma_id' => function() {
                if (Diploma::query()->exists()) {
                    return Diploma::query()->inRandomOrder()->first()->getKey();
                }
                return Diploma::factory();
            },
            'creator_id' => function() {
                if(Tutor::query()->exists()){
                    return Tutor::query()->inRandomOrder()->first()->user->getKey();
                }

                return Tutor::factory();
            },
        ];
    }
}
