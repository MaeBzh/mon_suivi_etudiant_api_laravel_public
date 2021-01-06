<?php

namespace Database\Factories;

use App\Models\SkillTemplate;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillTemplateFactory extends Factory{

    protected $model = SkillTemplate::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words($nb=6, $asText=true),
            'creator_id' => function() {
                if(Tutor::query()->exists()){
                    return Tutor::query()->inRandomOrder()->first()->user->getKey();
                }

                return Tutor::factory();
            },
        ];
    }

}
