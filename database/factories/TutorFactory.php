<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Tutor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorFactory extends Factory
{
    protected $model = Tutor::class;

    public function definition()
    {
        return [
            'company_id' => function() {
                return Company::factory();

            },
            'user_id' => function() {
                return User::factory();
            }
        ];
    }
}
