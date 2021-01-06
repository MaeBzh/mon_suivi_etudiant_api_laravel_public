<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'address1' => $this->faker->streetAddress,
            'address2' => $this->faker->secondaryAddress,
            'zipcode' => str_replace(' ', '', $this->faker->postcode),
            'city' => $this->faker->city,
        ];
    }
}
