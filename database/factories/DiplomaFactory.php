<?php

namespace Database\Factories;

use App\Models\Diploma;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiplomaFactory extends Factory
{
    protected $model = Diploma::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words($nb = 3, $asText = true),
            'creator_id' => function () {
                if (Tutor::query()->exists()) {
                    return Tutor::query()->inRandomOrder()->first()->user->getKey();
                }

                return Tutor::factory();
            }
        ];
    }
}
