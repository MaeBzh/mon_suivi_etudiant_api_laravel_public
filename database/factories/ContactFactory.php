<?php

namespace Database\Factories;

use App\Models\Contact;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'function' => $this->faker->jobTitle,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'school_id' => function () {
                return School::factory();
            }
        ];
    }
}
