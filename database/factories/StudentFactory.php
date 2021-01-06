<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\School;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        return [
            'school_id' => function() {
                return School::query()->inRandomOrder()->first()->getKey();
            },
            'tutor_id' => function() {
                return Tutor::factory();
            },
            'user_id' => function() {
                return User::factory();
            },
            'address_id' => function() {
                return Address::factory();
            },
            'active' => mt_rand(0, 1)
        ];
    }
}
